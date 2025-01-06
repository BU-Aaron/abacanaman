<?php

namespace App\Filament\Seller\Resources\Shop\DiscountResource\Pages;

use App\Filament\Seller\Resources\Shop\DiscountResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDiscounts extends ListRecords
{
    protected static string $resource = DiscountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
