<?php

namespace App\Filament\Admin\Clusters\Products\Resources\ProductResource\Pages;

use App\Filament\Admin\Clusters\Products\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    private $originalIsVisible;

    protected function beforeSave(): void
    {
        // Capture the original state of 'is_visible'
        $this->originalIsVisible = $this->record->is_visible;
    }

    protected function afterSave(): void
    {
        // Get the current state from the record
        $isVisible = $this->record->is_visible;

        // Only send notification if visibility changed
        if ($this->originalIsVisible !== $isVisible) {
            $sellerUser = $this->record->seller->user;

            if ($sellerUser) {
                $status = $isVisible ? 'visible' : 'hidden';

                Notification::make()
                    ->title('Product Visibility Updated')
                    ->icon($isVisible ? 'heroicon-o-eye' : 'heroicon-o-eye-slash')
                    ->body("Your product '{$this->record->name}' is now {$status} to customers.")
                    ->actions([
                        Action::make('View Product')
                            ->url("/seller/shop/products/{$this->record->id}/edit")
                            ->button()
                    ])
                    ->sendToDatabase($sellerUser);
            }
        }
    }

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
