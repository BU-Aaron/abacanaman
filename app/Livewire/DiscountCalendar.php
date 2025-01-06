<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Shop\Discount;

class DiscountCalendar extends Component
{
    public $events = [];

    public function mount()
    {
        $discounts = Discount::with('product')->get();
        $this->events = $discounts->map(function ($discount) {
            return [
                'title' => $discount->product->name . ' - ' . $discount->discount_percentage . '% Off',
                'start' => $discount->start_date,
                'end' => $discount->end_date, // FullCalendar treats 'end' as exclusive
                'url' => route('product-details', $discount->product->slug), // Optional: Link to the product
            ];
        });
    }

    public function render()
    {
        return view('livewire.discount-calendar');
    }
}
