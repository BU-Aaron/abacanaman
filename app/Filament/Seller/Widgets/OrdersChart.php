<?php

namespace App\Filament\Seller\Widgets;

use App\Models\Shop\Order;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;
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
        // Get the current authenticated seller
        $seller = Auth::user()->seller;

        // Get the last 12 months
        $months = collect([]);
        for ($i = 11; $i >= 0; $i--) {
            $months->push(Carbon::now()->subMonths($i));
        }

        // Query orders related to the seller's products
        $orderData = Order::whereHas('items.product', function ($query) use ($seller) {
            $query->where('shop_products.seller_id', $seller->id);
        })
            ->select(
                DB::raw("strftime('%Y-%m', created_at) as month"),
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
                ],
            ],
            'labels' => $months->map(fn($month) => $month->format('M'))->toArray(),
        ];
    }
}
