<?php

namespace App\Livewire;

use App\Models\Shop\Seller;
use Livewire\Component;

class SellerPage extends Component
{
    public $seller_id;
    public $seller;
    public $products;

    public function mount($seller_id)
    {
        $this->seller_id = $seller_id;
        $this->seller = Seller::with('user')->findOrFail($seller_id);
        $this->products = $this->seller->products()->where('is_visible', true)->get();
    }

    public function render()
    {
        return view('livewire.seller-page', [
            'seller' => $this->seller,
            'products' => $this->products,
        ]);
    }
}
