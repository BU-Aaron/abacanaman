<?php

namespace App\Filament\Admin\Clusters\Products\Resources\CategoryResource\Pages;

use App\Filament\Admin\Clusters\Products\Resources\CategoryResource;
use App\Filament\Admin\Imports\Shop\CategoryImporter;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCategories extends ListRecords
{
    protected static string $resource = CategoryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ImportAction::make()
                ->importer(CategoryImporter::class),
            Actions\CreateAction::make(),
        ];
    }
}
