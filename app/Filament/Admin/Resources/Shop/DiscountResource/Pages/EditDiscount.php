<?php

namespace App\Filament\Admin\Resources\Shop\DiscountResource\Pages;

use App\Filament\Admin\Resources\Shop\DiscountResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDiscount extends EditRecord
{
    protected static string $resource = DiscountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
