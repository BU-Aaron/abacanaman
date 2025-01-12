<?php

namespace App\Filament\Seller\Pages\Auth;

use Filament\Pages\Auth\EditProfile as BaseEditProfile;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Shop\Seller;
use Illuminate\Support\Facades\Auth;

class EditProfile extends BaseEditProfile
{
    protected ?string $maxWidth = '5xl';

    public function mount(): void
    {
        $this->form->fill([
            'name' => Auth::user()->name,
            'email' => Auth::user()->email,
            'contact_number' => Auth::user()->seller->contact_number,
            'store_logo' => Auth::user()->seller->store_logo,
            'document_proof' => Auth::user()->seller->document_proof,
            'store_description' => Auth::user()->seller->store_description,
            'address' => Auth::user()->seller->address,
            'city' => Auth::user()->seller->city,
            'state' => Auth::user()->seller->state,
            'zip_code' => Auth::user()->seller->zip_code,
        ]);
    }

    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        TextInput::make('name')
                            ->label('Name')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->maxLength(255),

                        TextInput::make('password')
                            ->label('New Password')
                            ->password()
                            ->maxLength(255)
                            ->nullable(),

                        TextInput::make('password_confirmation')
                            ->label('Confirm Password')
                            ->password()
                            ->maxLength(255)
                            ->same('password')
                            ->nullable(),

                        TextInput::make('contact_number')
                            ->label('Contact Number')
                            ->tel()
                            ->required()
                            ->maxLength(20),

                        FileUpload::make('store_logo')
                            ->label('Store Logo')
                            ->image()
                            ->directory('store-logos')
                            ->maxSize(5120)
                            ->nullable(),

                        Textarea::make('store_description')
                            ->label('About Your Store')
                            ->required()
                            ->maxLength(1000),

                        TextInput::make('address')
                            ->label('Street Address')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('city')
                            ->required()
                            ->maxLength(100),

                        TextInput::make('state')
                            ->required()
                            ->maxLength(100),

                        TextInput::make('zip_code')
                            ->required()
                            ->maxLength(20),
                    ])
                    ->statePath('data')
            ),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        // Update user-related fields
        $userData = [
            'name' => $data['name'],
            'email' => $data['email'],
        ];

        if (!empty($data['password'])) {
            $userData['password'] = Hash::make($data['password']);
        }

        $record->update($userData);

        // Update seller-related fields
        $sellerData = [
            'contact_number' => $data['contact_number'],
            'store_logo' => $data['store_logo'] ?? $record->seller->store_logo,
            'document_proof' => $data['document_proof'] ?? $record->seller->document_proof,
            'store_description' => $data['store_description'],
            'address' => $data['address'],
            'city' => $data['city'],
            'state' => $data['state'],
            'zip_code' => $data['zip_code'],
        ];

        $record->seller->update($sellerData);

        return $record;
    }
}
