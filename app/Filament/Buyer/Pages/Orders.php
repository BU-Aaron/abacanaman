<?php

namespace App\Filament\Buyer\Pages;

use Filament\Pages\Page;

class Orders extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static string $view = 'filament.buyer.pages.orders';
}
