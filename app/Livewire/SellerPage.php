<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use App\Models\Shop\Seller;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class SellerPage extends Component
{
    use LivewireAlert;

    public $seller_id;
    public $seller;
    public $products;

    public function mount($seller_id)
    {
        $this->seller_id = $seller_id;
        $this->seller = Seller::with('user')->findOrFail($seller_id);
        $this->products = $this->seller->products()
            ->where('is_visible', true)
            ->with('activeDiscount')
            ->get();
    }

    public function addToCart($product_id)
    {
        $total_count = CartManagement::addItemToCart($product_id);

        $this->dispatch('update-cart-count', total_count: $total_count)->to(Navbar::class);

        $this->alert('success', 'Product added to the cart successfully!', [
            'position' => 'bottom-end',
            'timer' => 3000,
            'toast' => true,
        ]);
    }

    public function render()
    {
        return view('livewire.seller-page', [
            'seller' => $this->seller,
            'products' => $this->products,
        ]);
    }
}
