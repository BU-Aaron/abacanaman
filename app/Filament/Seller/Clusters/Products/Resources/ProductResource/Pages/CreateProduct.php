<?php

namespace App\Filament\Seller\Clusters\Products\Resources\ProductResource\Pages;

use App\Filament\Seller\Clusters\Products\Resources\ProductResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;
}
