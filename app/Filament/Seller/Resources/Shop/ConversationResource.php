<?php

namespace App\Filament\Seller\Resources\Shop;

use App\Filament\Seller\Resources\ConversationResource\Pages;
use App\Filament\Seller\Resources\Shop\ConversationResource\Pages\CreateConversation;
use App\Filament\Seller\Resources\Shop\ConversationResource\Pages\EditConversation;
use App\Filament\Seller\Resources\Shop\ConversationResource\Pages\ListConversations;
use App\Filament\Seller\Resources\Shop\ConversationResource\Pages\ViewConversation;
use App\Models\Shop\Conversation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class ConversationResource extends Resource
{
    protected static ?string $model = Conversation::class;

    protected static ?string $modelLabel = 'Chat';

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';

    protected static ?string $navigationGroup = 'Shop';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationLabel = 'Chat';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('latestMessage.content')
                    ->label('Latest Message')
                    ->limit(50)
                    ->sortable()
                    ->toggleable()
                    ->wrap()
                    ->getStateUsing(function (Conversation $record) {
                        $message = $record->latestMessage;
                        if ($message) {
                            if ($message->sender_id === Auth::id()) {
                                return "You: " . $message->content;
                            }
                            return $message->content;
                        }
                        return '';
                    })
                    ->html(),

            ])
            ->filters([
                //
            ])
            ->actions([])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListConversations::route('/'),
            'create' => CreateConversation::route('/create'),
            'edit' => EditConversation::route('/{record}/edit'),
            'view' => ViewConversation::route('/{record}/view'),
        ];
    }

    /**
     * Override the Eloquent query to filter conversations by the authenticated seller.
     *
     * @return Builder
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where(function (Builder $query) {
                // Assuming Conversation has 'seller_id' field
                $sellerId = Auth::user()->seller->id;
                $query->where('seller_id', $sellerId);
            });
    }
}
