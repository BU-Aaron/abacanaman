<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

trait Multitenantable
{
    protected static function bootMultitenantable(): void
    {
        $user = Auth::user();
        $user = User::find($user->id);

        static::creating(function ($model) {
            $model->user_id = Auth::id();
        });

        if (! $user->hasRole('admin')) {
            static::addGlobalScope('created_by_user_id', function (Builder $builder) use ($user) {
                $builder->where('user_id', $user->id);
            });
        }
    }
}
