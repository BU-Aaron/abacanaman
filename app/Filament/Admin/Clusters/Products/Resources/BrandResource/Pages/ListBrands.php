<?php

namespace App\Filament\Admin\Clusters\Products\Resources\BrandResource\Pages;

use App\Filament\Admin\Clusters\Products\Resources\BrandResource;
use App\Filament\Admin\Exports\Shop\BrandExporter;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBrands extends ListRecords
{
    protected static string $resource = BrandResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ExportAction::make()
                ->exporter(BrandExporter::class),
            Actions\CreateAction::make(),
        ];
    }
}
