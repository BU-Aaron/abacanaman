<?php

namespace App\Filament\Seller\Widgets;

use App\Models\Shop\Order;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 0;

    protected function getStats(): array
    {
        // Get the current authenticated seller
        $seller = Auth::user()->seller;

        // Retrieve filter dates
        $startDate = !is_null($this->filters['startDate'] ?? null) ?
            Carbon::parse($this->filters['startDate']) :
            null;

        $endDate = !is_null($this->filters['endDate'] ?? null) ?
            Carbon::parse($this->filters['endDate']) :
            now();

        // Query orders related to the current seller
        $ordersQuery = Order::whereHas('items.product', function ($query) use ($seller) {
            $query->where('shop_products.seller_id', $seller->id);
        });

        // Apply date filters if available
        if ($startDate) {
            $ordersQuery->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $ordersQuery->whereDate('created_at', '<=', $endDate);
        }

        // Calculate Revenue
        $revenue = $ordersQuery->sum('total_price');

        // Calculate New Customers (distinct user_id)
        $newCustomers = $ordersQuery->distinct('user_id')->count('user_id');

        // Calculate New Orders
        $newOrders = $ordersQuery->count();

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
            Stat::make('Revenue', 'PHP ' . $formatNumber($revenue))
                ->description($startDate ? "{$formatNumber($revenue)} increase" : 'PHP ' . $formatNumber($revenue))
                ->descriptionIcon(
                    collect(
                        $ordersQuery->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_price) as daily_revenue'))
                            ->groupBy('date')
                            ->orderBy('date', 'desc')
                            ->limit(7)
                            ->pluck('daily_revenue')
                            ->reverse()
                            ->toArray()
                    )->first() > collect(
                        $ordersQuery->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_price) as daily_revenue'))
                            ->groupBy('date')
                            ->orderBy('date', 'desc')
                            ->limit(7)
                            ->pluck('daily_revenue')
                            ->reverse()
                            ->toArray()
                    )->last()
                        ? 'heroicon-m-arrow-trending-up'
                        : 'heroicon-m-arrow-trending-down'
                )
                ->chart($ordersQuery->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_price) as daily_revenue'))
                    ->groupBy('date')
                    ->orderBy('date', 'desc')
                    ->limit(7)
                    ->pluck('daily_revenue')
                    ->reverse()
                    ->toArray())
                ->color('success'),

            Stat::make('New Customers', $formatNumber($newCustomers))
                ->description($startDate ? "{$formatNumber($newCustomers)} increase" : $formatNumber($newCustomers))
                ->descriptionIcon(
                    collect(
                        $ordersQuery->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(DISTINCT user_id) as daily_customers'))
                            ->groupBy('date')
                            ->orderBy('date', 'desc')
                            ->limit(7)
                            ->pluck('daily_customers')
                            ->reverse()
                            ->toArray()
                    )->first() > collect(
                        $ordersQuery->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(DISTINCT user_id) as daily_customers'))
                            ->groupBy('date')
                            ->orderBy('date', 'desc')
                            ->limit(7)
                            ->pluck('daily_customers')
                            ->reverse()
                            ->toArray()
                    )->last()
                        ? 'heroicon-m-arrow-trending-up'
                        : 'heroicon-m-arrow-trending-down'
                )
                ->chart($ordersQuery->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(DISTINCT user_id) as daily_customers'))
                    ->groupBy('date')
                    ->orderBy('date', 'desc')
                    ->limit(7)
                    ->pluck('daily_customers')
                    ->reverse()
                    ->toArray())
                ->color(collect(
                    $ordersQuery->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(DISTINCT user_id) as daily_customers'))
                        ->groupBy('date')
                        ->orderBy('date', 'desc')
                        ->limit(7)
                        ->pluck('daily_customers')
                        ->reverse()
                        ->toArray()
                )->first() > collect(
                    $ordersQuery->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(DISTINCT user_id) as daily_customers'))
                        ->groupBy('date')
                        ->orderBy('date', 'desc')
                        ->limit(7)
                        ->pluck('daily_customers')
                        ->reverse()
                        ->toArray()
                )->last()
                    ? 'success'
                    : 'danger'),

            Stat::make('New Orders', $formatNumber($newOrders))
                ->description($startDate ? "{$formatNumber($newOrders)} increase" : $formatNumber($newOrders))
                ->descriptionIcon(
                    collect(
                        $ordersQuery->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(DISTINCT user_id) as daily_customers'))
                            ->groupBy('date')
                            ->orderBy('date', 'desc')
                            ->limit(7)
                            ->pluck('daily_customers')
                            ->reverse()
                            ->toArray()
                    )->first() > collect(
                        $ordersQuery->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(DISTINCT user_id) as daily_customers'))
                            ->groupBy('date')
                            ->orderBy('date', 'desc')
                            ->limit(7)
                            ->pluck('daily_customers')
                            ->reverse()
                            ->toArray()
                    )->last()
                        ? 'heroicon-m-arrow-trending-up'
                        : 'heroicon-m-arrow-trending-down'
                )
                ->chart($ordersQuery->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(DISTINCT user_id) as daily_customers'))
                    ->groupBy('date')
                    ->orderBy('date', 'desc')
                    ->limit(7)
                    ->pluck('daily_customers')
                    ->reverse()
                    ->toArray())
                ->color(collect(
                    $ordersQuery->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(DISTINCT user_id) as daily_customers'))
                        ->groupBy('date')
                        ->orderBy('date', 'desc')
                        ->limit(7)
                        ->pluck('daily_customers')
                        ->reverse()
                        ->toArray()
                )->first() > collect(
                    $ordersQuery->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(DISTINCT user_id) as daily_customers'))
                        ->groupBy('date')
                        ->orderBy('date', 'desc')
                        ->limit(7)
                        ->pluck('daily_customers')
                        ->reverse()
                        ->toArray()
                )->last()
                    ? 'success'
                    : 'danger'),
        ];
    }
}
