<?php

namespace App\Livewire;

use App\Models\Address;
use App\Models\Shop\Order;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Order Detail')]
class MyOrderDetailPage extends Component
{
    public $order_id;

    public function mount($order_id)
    {
        $this->order_id = $order_id;
    }

    public function render()
    {
        $order = Order::with('items.product')->find($this->order_id);
        $order_items = $order ? $order->items : [];
        $address = $order ? $order->address : [];

        return view('livewire.my-order-detail-page', [
            'order' => $order,
            'order_items' => $order_items,
            'address' => $address,
        ]);
    }
}
