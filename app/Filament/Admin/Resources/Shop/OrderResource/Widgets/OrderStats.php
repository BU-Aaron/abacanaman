<?php

namespace App\Filament\Admin\Resources\Shop\OrderResource\Widgets;

use App\Filament\Admin\Resources\Shop\OrderResource\Pages\ListOrders;
use App\Models\Shop\Order;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class OrderStats extends BaseWidget
{
    use InteractsWithPageTable;

    protected static ?string $pollingInterval = null;

    protected function getTablePage(): string
    {
        return ListOrders::class;
    }

    protected function getStats(): array
    {
        $orderData = Trend::model(Order::class)
            ->between(
                start: now()->subYear(),
                end: now(),
            )
            ->perMonth()
            ->count();

        return [
            Stat::make('Orders', $this->getPageTableQuery()->count())
                ->chart(
                    $orderData
                        ->map(fn(TrendValue $value) => $value->aggregate)
                        ->toArray()
                ),
            Stat::make('New orders', $this->getPageTableQuery()->whereIn('status', ['new'])->count()),
            Stat::make('Total price', number_format($this->getPageTableQuery()->sum('total_price'), 2)),
        ];
    }
}
