<?php

namespace App\Filament\Seller\Resources\Shop\PromotionResource\Pages;

use App\Filament\Seller\Resources\Shop\PromotionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPromotions extends ListRecords
{
    protected static string $resource = PromotionResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
