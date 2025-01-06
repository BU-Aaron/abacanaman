<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use App\Models\Shop\Product;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Product Details - Abacanaman')]
class ProductDetailPage extends Component
{
    use LivewireAlert;

    public Product $product;
    public $title;
    public $quantity = 1;

    // Review properties
    public $rating;
    public $comment;

    protected $rules = [
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'required|string|min:5|max:1000',
    ];

    public function mount($slug)
    {
        $this->product = Product::where('slug', $slug)->with(['media', 'comments.user'])->firstOrFail();
        $this->title = $this->product->name . " - Abacanaman";
    }

    public function increaseQty()
    {
        $this->quantity++;
    }

    public function decreaseQty()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    // Method for adding the product to the cart
    public function addToCart($product_id)
    {
        $total_count = CartManagement::addItemToCart($product_id, $this->quantity);

        $this->dispatch('update-cart-count', total_count: $total_count)->to(Navbar::class);

        $this->alert('success', 'Product added to the cart successfully!', [
            'position' => 'bottom-end',
            'timer' => 3000,
            'toast' => true,
        ]);
    }

    // Method to submit a review
    public function submitReview()
    {
        $this->validate();

        Comment::create([
            'user_id' => Auth::id(),
            'commentable_id' => $this->product->id,
            'commentable_type' => Product::class,
            'rating' => $this->rating,
            'title' => 'Review by ' . Auth::user()->name,
            'content' => $this->comment,
            'is_visible' => false, // Pending approval
        ]);

        $this->reset(['rating', 'comment']);

        $this->alert('success', 'Your review has been submitted and is pending approval.', [
            'position' => 'bottom-end',
            'timer' => 3000,
            'toast' => true,
        ]);
    }

    public function render()
    {
        return view('livewire.product-detail-page', ['product' => $this->product])
            ->layoutData(['title' => $this->title]);
    }
}
