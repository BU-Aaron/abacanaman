<?php

namespace App\Filament\Seller\Clusters\Products\Resources\ProductResource\Pages;

use App\Filament\Seller\Clusters\Products\Resources\ProductResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

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
}
