<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

trait Multitenantable
{
    protected static function bootMultitenantable(): void
    {
        static::creating(function ($model) {
            if (Auth::check()) {
                $model->user_id = Auth::id();
            }
        });

        static::addGlobalScope('created_by_user_id', function (Builder $builder) {
            if (Auth::check()) {
                $user = Auth::user();
                $user = User::find($user->id);

                if ($user->hasRole('seller')) {
                    $builder->where('user_id', $user->id);
                }
            }
        });
    }
}
