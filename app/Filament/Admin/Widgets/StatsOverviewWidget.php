<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Shop\Order;
use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class StatsOverviewWidget extends BaseWidget
{
    use InteractsWithPageFilters;

    protected static ?int $sort = 0;

    protected function getStats(): array
    {
        // Retrieve filter dates
        $startDate = ! is_null($this->filters['startDate'] ?? null) ?
            Carbon::parse($this->filters['startDate']) :
            null;

        $endDate = ! is_null($this->filters['endDate'] ?? null) ?
            Carbon::parse($this->filters['endDate']) :
            now();

        // Business Customers Only filter
        $isBusinessCustomersOnly = $this->filters['businessCustomersOnly'] ?? null;

        // Adjust multiplier based on filter
        $businessCustomerMultiplier = match (true) {
            boolval($isBusinessCustomersOnly) => 2 / 3,
            blank($isBusinessCustomersOnly) => 1,
            default => 1 / 3,
        };

        // Build the base query for orders
        $ordersQuery = Order::query();

        // Apply date filters if available
        if ($startDate) {
            $ordersQuery->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $ordersQuery->whereDate('created_at', '<=', $endDate);
        }

        // Apply business customers filter
        if (boolval($isBusinessCustomersOnly)) {
            $ordersQuery->whereHas('user', function ($query) {
                $query->where('is_business', true);
            });
        }

        // Calculate Revenue
        $revenue = $ordersQuery->sum('total_price') * $businessCustomerMultiplier;

        // Calculate New Customers (distinct user_id)
        $newCustomers = $ordersQuery->distinct('user_id')->count('user_id') * $businessCustomerMultiplier;

        // Calculate New Orders
        $newOrders = $ordersQuery->count() * $businessCustomerMultiplier;

        // Format numbers
        $formatNumber = function (int $number): string {
            if ($number < 1000) {
                return (string) number_format($number, 0);
            }

            if ($number < 1000000) {
                return number_format($number / 1000, 2) . 'k';
            }

            return number_format($number / 1000000, 2) . 'm';
        };

        return [
            Stat::make('Total Revenue', 'PHP ' . $formatNumber($revenue))
                ->description($revenue >= 0 ? 'Increase' : 'Decrease')
                ->descriptionIcon($revenue >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->chart($this->getRevenueChartData($startDate, $endDate))
                ->color($revenue >= 0 ? 'success' : 'danger'),

            Stat::make('New Customers', $formatNumber($newCustomers))
                ->description($newCustomers >= 0 ? 'Increase' : 'Decrease')
                ->descriptionIcon($newCustomers >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->chart($this->getCustomersChartData($startDate, $endDate))
                ->color($newCustomers >= 0 ? 'success' : 'danger'),

            Stat::make('New Orders', $formatNumber($newOrders))
                ->description($newOrders >= 0 ? 'Increase' : 'Decrease')
                ->descriptionIcon($newOrders >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->chart($this->getOrdersChartData($startDate, $endDate))
                ->color($newOrders >= 0 ? 'success' : 'danger'),
        ];
    }

    /**
     * Get Revenue Chart Data
     */
    protected function getRevenueChartData(?Carbon $startDate, Carbon $endDate): array
    {
        $revenueData = Order::select(DB::raw("DATE(created_at) as date"), DB::raw('SUM(total_price) as daily_revenue'))
            ->when($startDate, fn($query) => $query->whereDate('created_at', '>=', $startDate))
            ->when($endDate, fn($query) => $query->whereDate('created_at', '<=', $endDate))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->pluck('daily_revenue', 'date')
            ->toArray();

        // Ensure the chart displays dates in order
        ksort($revenueData);

        return array_values($revenueData);
    }

    /**
     * Get Customers Chart Data
     */
    protected function getCustomersChartData(?Carbon $startDate, Carbon $endDate): array
    {
        $customerData = Order::select(DB::raw("DATE(created_at) as date"), DB::raw('COUNT(DISTINCT user_id) as daily_customers'))
            ->when($startDate, fn($query) => $query->whereDate('created_at', '>=', $startDate))
            ->when($endDate, fn($query) => $query->whereDate('created_at', '<=', $endDate))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->pluck('daily_customers', 'date')
            ->toArray();

        ksort($customerData);

        return array_values($customerData);
    }

    /**
     * Get Orders Chart Data
     */
    protected function getOrdersChartData(?Carbon $startDate, Carbon $endDate): array
    {
        $orderData = Order::select(DB::raw("DATE(created_at) as date"), DB::raw('COUNT(*) as daily_orders'))
            ->when($startDate, fn($query) => $query->whereDate('created_at', '>=', $startDate))
            ->when($endDate, fn($query) => $query->whereDate('created_at', '<=', $endDate))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->pluck('daily_orders', 'date')
            ->toArray();

        ksort($orderData);

        return array_values($orderData);
    }
}
