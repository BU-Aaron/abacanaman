<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Shop\Order;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class CustomersChart extends ChartWidget
{
    protected static ?string $heading = 'Total customers';

    protected static ?int $sort = 2;

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

        // Query to get unique customers count per month across all orders
        $customerCounts = Order::select(
            DB::raw($this->getMonthFormatting()),
            DB::raw('COUNT(DISTINCT user_id) as customer_count')
        )
            ->where('created_at', '>=', now()->subMonths(11)->startOfMonth())
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('customer_count', 'month')
            ->toArray();

        // Prepare data for all months (including months with zero customers)
        $monthlyData = $months->mapWithKeys(function ($month) use ($customerCounts) {
            $key = $month->format('Y-m');
            return [$key => $customerCounts[$key] ?? 0];
        });

        return [
            'datasets' => [
                [
                    'label' => 'Customers',
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
        // Check the database driver
        $driver = config('database.default');

        return match ($driver) {
            'sqlite' => "strftime('%Y-%m', created_at) as month",
            'mysql' => "DATE_FORMAT(created_at, '%Y-%m') as month",
            'pgsql' => "to_char(created_at, 'YYYY-MM') as month",
            default => "DATE_FORMAT(created_at, '%Y-%m') as month",
        };
    }
}
