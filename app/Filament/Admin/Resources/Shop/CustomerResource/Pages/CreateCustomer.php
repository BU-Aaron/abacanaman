<?php

namespace App\Filament\Admin\Resources\Shop\CustomerResource\Pages;

use App\Filament\Admin\Resources\Shop\CustomerResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomer extends CreateRecord
{
    protected static string $resource = CustomerResource::class;
}
