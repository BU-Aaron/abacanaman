<?php

namespace App\Filament\Admin\Resources\Blog\CategoryResource\Pages;

use App\Filament\Admin\Resources\Blog\CategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;
}
