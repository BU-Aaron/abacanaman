<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Laravel\Sanctum\HasApiTokens;

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
     * @var array<string, string>
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
}
