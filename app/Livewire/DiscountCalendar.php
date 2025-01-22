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
        // Fetch active promotions
        $promotions = Promotion::with('products')->get();

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

        $this->events = $promotionEvents->toArray();
    }

    public function render()
    {
        return view('livewire.discount-calendar');
    }
}
