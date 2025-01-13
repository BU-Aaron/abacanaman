<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\SellerResource\Pages;
use App\Filament\Admin\Resources\SellerResource\RelationManagers;
use App\Models\Shop\Seller;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Notifications\Collection;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SellerResource extends Resource
{
    protected static ?string $model = Seller::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';

    protected static ?string $navigationGroup = 'User Management';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Sellers';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('store_name')
                    ->required()
                    ->maxLength(255)
                    ->readOnly(),

                Textarea::make('store_description')
                    ->rows(3)
                    ->maxLength(1000)
                    ->readOnly(),

                TextInput::make('contact_number')
                    ->label('Contact Number')
                    ->tel()
                    ->readOnly(),

                TextInput::make('address')
                    ->label('Address')
                    ->maxLength(255)
                    ->readOnly(),

                TextInput::make('city')
                    ->label('City')
                    ->maxLength(255)
                    ->readOnly(),

                TextInput::make('state')
                    ->label('State')
                    ->maxLength(255)
                    ->readOnly(),

                FileUpload::make('store_logo')
                    ->label('Store Logo')
                    ->image()
                    ->directory('store-logos')
                    ->imageResizeTargetWidth(300)
                    ->imageResizeTargetHeight(300)
                    ->deletable(false),

                FileUpload::make('document_proof')
                    ->label('Business Document')
                    ->image()
                    ->directory('seller-documents')
                    ->maxSize(5120)
                    ->imagePreviewHeight('400')
                    ->openable()
                    ->downloadable()
                    ->deletable(false)
                    ->imageResizeMode('cover'),

                Toggle::make('is_verified')
                    ->label('Verified')
                    ->helperText('Mark the seller as verified after reviewing.')
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('store_name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('user.name')
                    ->label('User Name')
                    ->searchable()
                    ->sortable(),

                IconColumn::make('is_verified')
                    ->label('Verified')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('contact_number')
                    ->label('Contact'),

                TextColumn::make('created_at')
                    ->label('Registered At')
                    ->dateTime('M d, Y'),
            ])
            ->filters([
                Tables\Filters\Filter::make('verified')
                    ->query(fn($query) => $query->where('is_verified', true)),

                Tables\Filters\Filter::make('pending_verification')
                    ->query(fn($query) => $query->where('is_verified', false)),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('View'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),

                    Action::make('bulk_verify')
                        ->label('Verify Selected')
                        ->icon('heroicon-o-check-circle')
                        ->action(function (Collection $records) {
                            $records->each->update(['is_verified' => true]);
                            Notification::make()
                                ->title('Sellers Verified')
                                ->body('Selected sellers have been successfully verified.')
                                ->success()
                                ->send();
                        })
                        ->requiresConfirmation(),
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
            'index' => Pages\ListSellers::route('/'),
            'create' => Pages\CreateSeller::route('/create'),
            'edit' => Pages\EditSeller::route('/{record}/edit'),
        ];
    }
}
