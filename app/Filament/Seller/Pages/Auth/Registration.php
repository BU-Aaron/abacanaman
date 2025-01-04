<?php

namespace App\Filament\Seller\Pages\Auth;

use App\Models\User;
use Filament\Pages\Auth\Register;
use Illuminate\Database\Eloquent\Model;

class Registration extends Register
{
    protected function handleRegistration(array $data): Model
    {
        $user = $this->getUserModel()::create(
            array_merge($data, [
                'role' => User::ROLE_SELLER,
            ])
        );

        return $user;
    }
}
