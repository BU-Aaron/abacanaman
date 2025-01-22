<?php

namespace App\Filament\Admin\Resources\Shop\PromotionResource\Pages;

use App\Filament\Admin\Resources\Shop\PromotionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePromotion extends CreateRecord
{
    protected static string $resource = PromotionResource::class;

    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction(),
            $this->getCancelFormAction()
        ];
    }
}
