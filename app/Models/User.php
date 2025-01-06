<?php

namespace App\Models;

use App\Models\Shop\Order;
use App\Models\Shop\Payment;
use App\Models\Shop\Seller;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    // Define role constants
    public const ROLE_ADMIN = 'admin';
    public const ROLE_BUYER = 'buyer';
    public const ROLE_SELLER = 'seller';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     *
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Check if the user has a specific role.
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    /**
     * Determine if the user can access a given Filament panel.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        switch ($this->role) {
            case self::ROLE_BUYER:
                return $panel->getId() === 'buyer';
            case self::ROLE_ADMIN:
                return $panel->getId() === 'admin';
            case self::ROLE_SELLER:
                return $panel->getId() === 'seller';
            default:
                return false;
        }
    }

    /**
     * Get the orders associated with the user.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    /**
     * Get the payments associated with the user's orders.
     */
    public function payments(): HasManyThrough
    {
        return $this->hasManyThrough(Payment::class, Order::class, 'user_id', 'order_id');
    }

    /**
     * Get the comments made by the user.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'user_id');
    }

    /**
     * Get the addresses associated with the user.
     */
    public function addresses(): MorphToMany
    {
        return $this->morphToMany(Address::class, 'addressable');
    }

    /**
     * Get the seller associated with the user.
     */
    public function seller(): HasOne
    {
        return $this->hasOne(Seller::class, 'user_id');
    }
}
