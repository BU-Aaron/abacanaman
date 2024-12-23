<?php

namespace App\Filament\Seller\Resources\Blog\PostResource\Pages;

use App\Filament\Seller\Resources\Blog\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPosts extends ListRecords
{
    protected static string $resource = PostResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
