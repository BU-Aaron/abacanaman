<?php

namespace App\Filament\Admin\Resources\SellerResource\Pages;

use App\Filament\Admin\Resources\SellerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditSeller extends EditRecord
{
    protected static string $resource = SellerResource::class;

    protected static ?string $title = 'Verify Seller';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\Action::make('verify_seller')
                ->label('Verify Seller')
                ->color('success')
                ->icon('heroicon-o-check-circle')
                ->action(function () {
                    // Update the seller's verification status
                    $this->record->is_verified = true;
                    $this->record->save();

                    // Verify the associated user's email if not already verified
                    if ($this->record->user && !$this->record->user->hasVerifiedEmail()) {
                        $this->record->user->markEmailAsVerified();
                    }

                    // Add a success notification using the Notification facade
                    Notification::make()
                        ->title('Seller Verified')
                        ->body("Seller {$this->record->store_name} has been verified successfully.")
                        ->success()
                        ->send();
                })
                ->requiresConfirmation() // Adds a confirmation dialog
                ->visible(!$this->record->is_verified), // Shows the button only if not verified
        ];
    }
}
