<?php

namespace App\Livewire;

use App\Models\Shop\Order;
use Livewire\Component;
use Livewire\Attributes\Title;
use Jantinnerezo\LivewireAlert\LivewireAlert;

#[Title('Order Detail')]
class MyOrderDetailPage extends Component
{
    use LivewireAlert;

    public $order_id;

    public function mount($order_id)
    {
        $this->order_id = $order_id;
    }

    public function confirmDelivered()
    {
        $order = $this->getOrder();

        if ($order->status->value !== 'shipped') {
            $this->alert('error', 'Order cannot be marked as delivered at this stage.');
            return;
        }

        $order->status = 'delivered';
        $order->save();

        $this->alert(
            'success',
            'Order has been marked as delivered.',
            [
                'position' => 'top',
                'timer' => 3000,
                'toast' => true,
            ]
        );
    }

    public function cancelOrder()
    {
        $order = $this->getOrder();

        if (in_array($order->status->value, ['delivered', 'cancelled'])) {
            $this->alert(
                'error',
                'Order cannot be cancelled.',
                [
                    'position' => 'top',
                    'timer' => 3000,
                    'toast' => true,
                ]
            );
            return;
        }

        $order->status = 'cancelled';
        $order->save();

        $this->alert(
            'success',
            'Order has been cancelled.',
            [
                'position' => 'top',
                'timer' => 3000,
                'toast' => true,
            ]
        );
    }

    private function getOrder()
    {
        return Order::findOrFail($this->order_id);
    }

    public function render()
    {
        $order = $this->getOrder()->load('items.product', 'address');

        return view('livewire.my-order-detail-page', [
            'order' => $order,
            'order_items' => $order->items,
            'address' => $order->address,
        ]);
    }
}
