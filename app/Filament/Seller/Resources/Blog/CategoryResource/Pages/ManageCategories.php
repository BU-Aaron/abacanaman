<?php

namespace App\Filament\Seller\Resources\Blog\CategoryResource\Pages;

use App\Filament\Seller\Imports\Blog\CategoryImporter;
use App\Filament\Seller\Resources\Blog\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageCategories extends ManageRecords
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
