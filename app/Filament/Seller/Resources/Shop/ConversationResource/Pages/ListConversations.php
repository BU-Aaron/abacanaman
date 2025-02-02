<?php

namespace App\Filament\Seller\Resources\Shop\ConversationResource\Pages;

use App\Filament\Seller\Resources\Shop\ConversationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListConversations extends ListRecords
{
    protected static string $resource = ConversationResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function getTableActions(): array
    {
        return [
            Actions\ViewAction::make()
                ->label('View Chat')
                ->icon('heroicon-o-chat-bubble-left-ellipsis'),
        ];
    }
}
