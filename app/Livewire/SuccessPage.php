<?php

namespace App\Livewire;

use App\Models\Shop\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Success')]
class SuccessPage extends Component
{
    public function render()
    {
        $latest_order = Order::with('address')->where('user_id', Auth::user()->id)->latest()->first();

        return view('livewire.success-page', [
            'latest_order' => $latest_order,
        ]);
    }
}
