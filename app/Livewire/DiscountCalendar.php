<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Shop\Discount;
use App\Models\Shop\Promotion;

class DiscountCalendar extends Component
{
    public $events = [];

    public function mount()
    {
        // Fetch active and verified discounts
        $discounts = Discount::with('product')->where('is_verified', true)->get();

        // Fetch active promotions
        $promotions = Promotion::with('products')->get();

        // Map discounts to calendar events
        $discountEvents = $discounts->map(function ($discount) {
            return [
                'title' => "{$discount->product->name} - {$discount->discount_percentage}% Off (Discount)",
                'start' => $discount->start_date,
                'end' => $discount->end_date, // FullCalendar treats 'end' as exclusive
                'url' => route('product-details', $discount->product->slug),
            ];
        });

        // Map promotions to calendar events
        $promotionEvents = $promotions->flatMap(function ($promotion) {
            return $promotion->products->map(function ($product) use ($promotion) {
                return [
                    'title' => "{$product->name} - {$promotion->discount_percentage}% Off (Promotion)",
                    'start' => $promotion->start_date,
                    'end' => $promotion->end_date,
                    'url' => route('product-details', $product->slug),
                ];
            });
        });

        // Merge both discount and promotion events
        $this->events = $discountEvents->merge($promotionEvents)->toArray();
    }

    public function render()
    {
        return view('livewire.discount-calendar');
    }
}
