<?php

namespace App\Filament\Seller\Resources\Shop\PromotionResource\Pages;

use App\Filament\Seller\Resources\Shop\PromotionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;

class CreatePromotion extends CreateRecord
{
    protected static string $resource = PromotionResource::class;

    /**
     * Modify form data before creating the record.
     *
     * @param array $data
     * @return array
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Retrieve the authenticated seller
        $seller = Auth::user()->seller;

        // Ensure the seller exists
        if (!$seller) {
            throw new \Exception('Authenticated user does not have a seller profile.');
        }

        // Assign the seller_id to the form data
        $data['seller_id'] = $seller->id;

        return $data;
    }

    /**
     * After creating the promotion, sync the selected products.
     */
    protected function afterCreate(): void
    {
        // Sync the selected products with the promotion
        $this->record->products()->sync($this->record->getAttribute('products'));

        // Optional: Send a notification
        Notification::make()
            ->title('Promotion Created')
            ->body("Promotion '{$this->record->name}' has been successfully created.")
            ->success()
            ->send();
    }
}
