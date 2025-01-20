<?php

namespace App\Filament\Seller\Resources\Shop\PromotionResource\RelationManagers;

use App\Filament\Seller\Clusters\Products\Resources\ProductResource;
use App\Models\Shop\Product;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ProductsRelationManager extends RelationManager
{
    protected static string $relationship = 'products';

    protected static ?string $recordTitleAttribute = 'name';

    public function table(Table $table): Table
    {
        return ProductResource::table($table)
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->label('Add Product')
                    ->form([
                        Select::make('recordId') // Ensure this matches Filament's expectation
                            ->label('Select Product')
                            ->options(Product::query()->pluck('name', 'id'))
                            ->searchable()
                            ->required()
                    ]),
            ])
            ->actions([
                Tables\Actions\DetachAction::make()->label('Remove Product'),
            ])
            ->groupedBulkActions([
                Tables\Actions\DetachBulkAction::make()->label('Remove Products'),
            ]);
    }
}
