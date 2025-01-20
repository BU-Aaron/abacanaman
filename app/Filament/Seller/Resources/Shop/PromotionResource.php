<?php

namespace App\Filament\Seller\Resources\Shop;

use App\Filament\Seller\Resources\Shop\PromotionResource\Pages;
use App\Filament\Seller\Resources\Shop\PromotionResource\RelationManagers\ProductsRelationManager;
use App\Models\Shop\Promotion;
use App\Models\Shop\Product;
use Filament\Forms;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;

class PromotionResource extends Resource
{
    protected static ?string $model = Promotion::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $navigationGroup = 'Shop';
    protected static ?string $navigationLabel = 'Promotions';
    protected static ?int $navigationSort = 4;

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->disabled()
                    ->required()
                    ->maxLength(255),

                TextInput::make('discount_percentage')
                    ->disabled()
                    ->label('Discount Percentage (%)')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100)
                    ->required(),

                DatePicker::make('start_date')
                    ->disabled()
                    ->required()
                    ->reactive()
                    ->afterOrEqual('today'),

                DatePicker::make('end_date')
                    ->disabled()
                    ->required()
                    ->afterOrEqual('start_date'),

                Textarea::make('description')
                    ->disabled()
                    ->rows(3)
                    ->maxLength(1000)
                    ->required(),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('discount_percentage')
                    ->label('Discount (%)')
                    ->sortable(),

                TextColumn::make('start_date')
                    ->label('Start Date')
                    ->date()
                    ->sortable(),

                TextColumn::make('end_date')
                    ->label('End Date')
                    ->date()
                    ->sortable(),
            ])
            ->actions([
                // Define any table actions if needed
            ])
            ->bulkActions([
                // Define any bulk actions if needed
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ProductsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPromotions::route('/'),
            'create' => Pages\CreatePromotion::route('/create'),
            'edit' => Pages\EditPromotion::route('/{record}/edit'),
        ];
    }
}
