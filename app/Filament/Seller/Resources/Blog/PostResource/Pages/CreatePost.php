<?php

namespace App\Filament\Seller\Resources\Blog\PostResource\Pages;

use App\Filament\Seller\Resources\Blog\PostResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;

    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction(),
            $this->getCancelFormAction()
        ];
    }
}
