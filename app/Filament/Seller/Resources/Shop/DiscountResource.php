<?php

namespace App\Filament\Seller\Resources\Shop;

use App\Filament\Seller\Resources\DiscountResource\Pages;
use App\Filament\Seller\Resources\DiscountResource\RelationManagers;
use App\Filament\Seller\Resources\Shop\DiscountResource\Pages\CreateDiscount;
use App\Filament\Seller\Resources\Shop\DiscountResource\Pages\EditDiscount;
use App\Filament\Seller\Resources\Shop\DiscountResource\Pages\ListDiscounts;
use App\Models\Shop\Discount;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class DiscountResource extends Resource
{
    protected static ?string $model = Discount::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationGroup = 'Shop';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'Discount';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('shop_product_id')
                    ->label('Product')
                    ->preload()
                    ->relationship('product', 'name')
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('discount_percentage')
                    ->label('Discount Percentage (%)')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100)
                    ->required(),
                Forms\Components\DatePicker::make('start_date')
                    ->required()
                    ->reactive()
                    ->afterOrEqual('today')
                    ->default(today()),
                Forms\Components\DatePicker::make('end_date')
                    ->required()
                    ->afterOrEqual('start_date')
                    ->default(today()->addDays(7)),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.name')->label('Product')->sortable()->searchable(),
                Tables\Columns\IconColumn::make('is_verified')
                    ->label('Verified')
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('discount_percentage')->label('Discount (%)')->sortable(),
                Tables\Columns\TextColumn::make('start_date')->label('Start Date')->sortable(),
                Tables\Columns\TextColumn::make('end_date')->label('End Date')->sortable(),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDiscounts::route('/'),
            'create' => CreateDiscount::route('/create'),
            'edit' => EditDiscount::route('/{record}/edit'),
        ];
    }

    /**
     * Override the Eloquent query to filter discounts by the authenticated seller's products.
     *
     * @return Builder
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('product', function (Builder $query) {
                $sellerId = Auth::user()->seller->id;
                $query->where('seller_id', $sellerId);
            });
    }
}
