<?php

namespace App\Filament\Admin\Resources\Shop;

use App\Filament\Admin\Resources\Shop\PromotionResource\Pages\CreatePromotion;
use App\Filament\Admin\Resources\Shop\PromotionResource\Pages\EditPromotion;
use App\Filament\Admin\Resources\Shop\PromotionResource\Pages\ListPromotions;
use App\Models\Shop\Promotion;
use Filament\Forms;
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
    protected static ?string $navigationGroup = 'Seller Shops';
    protected static ?string $navigationLabel = 'Promotions';
    protected static ?int $navigationSort = 4;

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('discount_percentage')
                    ->label('Discount Percentage (%)')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100)
                    ->required(),

                DatePicker::make('start_date')
                    ->required()
                    ->default(today())
                    ->reactive()
                    ->afterOrEqual('today'),

                DatePicker::make('end_date')
                    ->required()
                    ->afterOrEqual('start_date')
                    ->default(today()->addDays(7)),

                Textarea::make('description')
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
            'index' => ListPromotions::route('/'),
            'create' => CreatePromotion::route('/create'),
            'edit' => EditPromotion::route('/{record}/edit'),
        ];
    }
}
