<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait SellerOwnsOrderItems
{
    /**
     * Boot the SellerOwnsOrderItems trait for a model.
     *
     * @return void
     */
    protected static function bootSellerOwnsOrderItems(): void
    {
        static::addGlobalScope('seller_owns_order_items', function (Builder $builder) {
            // Check if the user is authenticated and has the 'seller' role
            $user = Auth::user();
            $user = User::find($user->id);
            if ($user->hasRole('seller')) {
                $sellerId = Auth::user()->seller->id;

                // Restrict OrderItems to those where the related Product is owned by the seller
                $builder->whereHas('product', function (Builder $query) use ($sellerId) {
                    $query->where('seller_id', $sellerId);
                });
            }
        });
    }
}
