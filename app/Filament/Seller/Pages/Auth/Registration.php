<?php

namespace App\Filament\Seller\Pages\Auth;

use App\Models\Shop\Seller;
use App\Models\User;
use Filament\Forms\Components\FileUpload;
use Filament\Pages\Auth\Register;
use Illuminate\Database\Eloquent\Model;

class Registration extends Register
{
    protected function handleRegistration(array $data): Model
    {
        // First create the user
        $user = $this->getUserModel()::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => User::ROLE_SELLER,
        ]);

        // Then create the seller profile with the store logo
        $seller = Seller::create([
            'user_id' => $user->id,
            'store_name' => $data['name'],
            'store_logo' => $data['store_logo'] ?? null,
        ]);

        return $user;
    }

    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                        FileUpload::make('store_logo')
                            ->label('Store Logo')
                            ->image()
                            ->imageEditor()
                            ->directory('store-logos')
                            ->maxSize(5120) // 5MB
                            ->helperText('Upload your store logo (max 5MB)')
                    ])
                    ->statePath('data'),
            ),
        ];
    }
}
