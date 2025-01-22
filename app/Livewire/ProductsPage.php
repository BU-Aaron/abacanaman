<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use App\Models\Shop\Seller;
use App\Models\Shop\Category;
use App\Models\Shop\Product;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Products - Abacanaman')]
class ProductsPage extends Component
{
    use LivewireAlert;
    use WithPagination;

    #[Url]
    public $selected_sellers = [];

    #[Url]
    public $selected_categories = [];

    #[Url]
    public $featured = false;

    #[Url]
    public $price_range = 0;

    #[Url]
    public $sort = 'latest';

    protected $paginationTheme = 'tailwind';

    protected $queryString = [
        'selected_sellers',
        'selected_categories',
        'featured',
        'price_range',
        'sort',
    ];

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
        $productsQuery = Product::query()->where('is_visible', true);

        $sellers = Seller::with('user')->whereHas('user', function ($query) {
            $query->where('role', 'seller');
        })->where('is_verified', 1)->get(['id', 'store_name', 'user_id']);

        $categories = Category::where('is_visible', true)->get(['id', 'name', 'slug']);

        if (!empty($this->selected_sellers)) {
            $productsQuery->whereIn('seller_id', $this->selected_sellers);
        }

        if (!empty($this->selected_categories)) {
            $productsQuery->whereHas('categories', function ($query) {
                $query->whereIn('shop_categories.id', $this->selected_categories);
            });
        }

        if ($this->featured) {
            $productsQuery->where('featured', true);
        }

        if ($this->price_range > 0) {
            $productsQuery->whereBetween('price', [0, $this->price_range]);
        }

        // Apply sorting
        switch ($this->sort) {
            case 'price_asc':
                $productsQuery->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $productsQuery->orderBy('price', 'desc');
                break;
            default:
                $productsQuery->latest();
                break;
        }

        $products = $productsQuery->with(['media'])->paginate(12);

        return view('livewire.products-page', [
            'sellers' => $sellers,
            'categories' => $categories,
            'products' => $products,
        ]);
    }
}
