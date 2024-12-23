<?php

namespace App\Filament\Seller\Resources\Blog\LinkResource\Pages;

use App\Filament\Seller\Resources\Blog\LinkResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewLink extends ViewRecord
{
    use ViewRecord\Concerns\Translatable;

    protected static string $resource = LinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\LocaleSwitcher::make(),
        ];
    }
}
