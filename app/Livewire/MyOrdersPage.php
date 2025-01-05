<?php

namespace App\Livewire;

use App\Models\Shop\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

#[Title('My Orders')]
class MyOrdersPage extends Component
{
    use WithPagination;

    public function render()
    {
        $my_orders = Order::where('user_id', Auth::user()->id)->latest()->paginate(10);
        return view('livewire.my-orders-page', [
            'orders' => $my_orders,
        ]);
    }
}
