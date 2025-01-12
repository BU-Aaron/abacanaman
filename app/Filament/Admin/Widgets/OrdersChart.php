<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Shop\Order;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class OrdersChart extends ChartWidget
{
    protected static ?string $heading = 'Orders per month';

    protected static ?int $sort = 1;

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        // Get the last 12 months
        $months = collect([]);
        for ($i = 11; $i >= 0; $i--) {
            $months->push(Carbon::now()->subMonths($i));
        }

        // Query all orders
        $orderData = Order::select(
            DB::raw($this->getMonthFormatting()),
            DB::raw('COUNT(*) as total')
        )
            ->where('created_at', '>=', now()->subMonths(11)->startOfMonth())
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Prepare data for all months (including months with 0 orders)
        $monthlyData = $months->mapWithKeys(function ($month) use ($orderData) {
            $key = $month->format('Y-m');
            return [$key => $orderData[$key] ?? 0];
        });

        return [
            'datasets' => [
                [
                    'label' => 'Orders',
                    'data' => array_values($monthlyData->toArray()),
                    'fill' => 'start',
                    'tension' => 0.4,
                ],
            ],
            'labels' => $months->map(fn($month) => $month->format('M'))->toArray(),
        ];
    }

    protected function getMonthFormatting(): string
    {
        $driver = config('database.default');

        return match ($driver) {
            'sqlite' => "strftime('%Y-%m', created_at) as month",
            'mysql' => "DATE_FORMAT(created_at, '%Y-%m') as month",
            'pgsql' => "to_char(created_at, 'YYYY-MM') as month",
            default => "DATE_FORMAT(created_at, '%Y-%m') as month",
        };
    }
}
