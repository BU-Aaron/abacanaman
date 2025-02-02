<?php

namespace App\Filament\Admin\Resources\Blog\LinkResource\Pages;

use App\Filament\Admin\Resources\Blog\LinkResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLinks extends ListRecords
{
    use ListRecords\Concerns\Translatable;

    protected static string $resource = LinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\LocaleSwitcher::make(),
        ];
    }
}
