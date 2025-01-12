<?php

namespace App\Filament\Seller\Pages\Auth;

use App\Models\Shop\Seller;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Pages\Auth\Register;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Filament\Actions\Action;

class Registration extends Register
{
    protected ?string $maxWidth = '3xl';

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Store Information')
                        ->schema([
                            TextInput::make('store_name')
                                ->label('Store Name')
                                ->required()
                                ->maxLength(255),

                            TextInput::make('contact_number')
                                ->label('Contact Number')
                                ->required()
                                ->tel()
                                ->maxLength(20),

                            FileUpload::make('store_logo')
                                ->label('Store Logo')
                                ->image()
                                ->imageEditor()
                                ->directory('store-logos')
                                ->maxSize(5120),

                            FileUpload::make('document_proof')
                                ->label('Business Document')
                                ->image()
                                ->directory('seller-documents')
                                ->maxSize(5120)
                                ->required()
                                ->helperText('Upload a valid image document (e.g., Business License).'),

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
                        ->columns(2),

                    Step::make('Account Information')
                        ->schema([
                            $this->getEmailFormComponent(),
                            $this->getPasswordFormComponent(),
                            $this->getPasswordConfirmationFormComponent(),
                        ])
                        ->columns(1),
                ])
                    ->skippable(false)
                    ->persistStepInQueryString()
                    ->submitAction(new HtmlString(Blade::render(
                        <<<BLADE
                        <x-filament::button type="submit" size="sm" wire:submit="register">
                            Register
                        </x-filament::button>
                        BLADE
                    )))
            ]);
    }

    protected function getFormActions(): array
    {
        return [];
    }

    protected function handleRegistration(array $data): Model
    {
        // First create the user
        $user = $this->getUserModel()::create([
            'name' => $data['store_name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => User::ROLE_SELLER,
        ]);

        // Then create the seller profile with all the additional fields
        $seller = Seller::create([
            'user_id' => $user->id,
            'store_name' => $data['store_name'],
            'store_description' => $data['store_description'],
            'store_logo' => $data['store_logo'] ?? null,
            'contact_number' => $data['contact_number'],
            'address' => $data['address'],
            'city' => $data['city'],
            'state' => $data['state'],
            'zip_code' => $data['zip_code'],
            'document_proof' => $data['document_proof'] ?? null,
        ]);

        return $user;
    }
}
