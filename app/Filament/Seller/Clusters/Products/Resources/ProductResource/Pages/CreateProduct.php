<?php

namespace App\Filament\Seller\Clusters\Products\Resources\ProductResource\Pages;

use App\Filament\Admin\Clusters\Products\Resources\ProductResource as AdminProductResource;
use App\Filament\Seller\Clusters\Products\Resources\ProductResource;

use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

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

    protected function afterCreate(): void
    {
        // Get all admin users
        $admins = User::where('role', User::ROLE_ADMIN)->get();

        foreach ($admins as $admin) {
            Notification::make()
                ->title('New Product Created')
                ->icon('heroicon-o-plus-circle')
                ->body("A new product '{$this->record->name}' has been created by seller '{$this->record->seller->store_name}'.")
                ->actions([
                    Action::make('View Product')
                        ->url("/admin/products/{$this->record->id}/edit"),
                ])
                ->sendToDatabase($admin);
        }
    }

    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction(),
            $this->getCancelFormAction()
        ];
    }
}
