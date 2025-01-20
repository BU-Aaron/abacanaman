<?php

namespace App\Filament\Seller\Resources\Shop\PromotionResource\Pages;

use App\Filament\Seller\Resources\Shop\PromotionResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditPromotion extends EditRecord
{
    protected static string $resource = PromotionResource::class;

    protected static ?string $title = 'Add Products to Promotion';

    /**
     * After updating the promotion, sync the selected products.
     */
    protected function afterSave(): void
    {
        // Sync the selected products with the promotion
        $this->record->products()->sync($this->record->getAttribute('products'));

        // Optional: Send a notification
        Notification::make()
            ->title('Promotion Updated')
            ->body("Promotion '{$this->record->name}' has been successfully updated.")
            ->success()
            ->send();
    }

    /**
     * Override the header actions to remove any existing header actions.
     */
    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function getFormActions(): array
    {
        return [];
    }
}
