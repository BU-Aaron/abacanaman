<?php

namespace App\Filament\Admin\Exports\Shop;

use App\Models\Shop\Order;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Builder;

class OrderExporter extends Exporter
{
    protected static ?string $model = Order::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('date')
                ->state(fn($record) => date('Y-m-d', strtotime($record->created_at))),
            ExportColumn::make('number')
                ->state(fn($record) => $record->number),
            ExportColumn::make('customer_name')
                ->state(fn($record) => $record->customer->name),
            ExportColumn::make('total_orders')
                ->state(fn($record) => 1),
            ExportColumn::make('total_revenue')
                ->state(fn($record) => $record->total_price),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your order export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
