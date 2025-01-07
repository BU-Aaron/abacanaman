<?php

namespace App\Filament\Seller\Resources\Shop\OrderResource\RelationManagers;

use App\Models\Shop\OrderItem;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Resources\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class OrderItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static ?string $recordTitleAttribute = 'product.name';

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                // Define your form schema here
                Forms\Components\Select::make('shop_product_id')
                    ->label('Product')
                    ->options(fn() => Auth::user()->seller->products()->pluck('name', 'id'))
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, $set) {
                        $product = OrderItem::find($state);
                        $set('unit_price', $product ? $product->price : 0);
                    }),
                Forms\Components\TextInput::make('qty')
                    ->label('Quantity')
                    ->numeric()
                    ->required()
                    ->minValue(1),
                Forms\Components\TextInput::make('unit_price')
                    ->label('Unit Price')
                    ->disabled()
                    ->numeric()
                    ->required(),
            ]);
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.name')->label('Product')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('qty')->label('Quantity')->sortable(),
                Tables\Columns\TextColumn::make('unit_price')->label('Unit Price')->sortable(),
                Tables\Columns\TextColumn::make('total_price')->label('Total Price')->sortable()->getStateUsing(function ($record) {
                    return $record->qty * $record->unit_price;
                }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
