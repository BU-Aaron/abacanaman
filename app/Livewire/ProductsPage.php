<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use App\Models\Shop\Brand;
use App\Models\Shop\Category;
use App\Models\Shop\Product;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Products - ByteWebster')]
class ProductsPage extends Component
{
    use LivewireAlert;
    use WithPagination;

    #[Url]
    public $selected_categories = [];

    #[Url]
    public $selected_brands = [];

    #[Url]
    public $featured = false;

    #[Url]
    public $price_range = 0;

    #[Url]
    public $sort = 'latest';

    protected $paginationTheme = 'tailwind';

    protected $queryString = [
        'selected_categories',
        'selected_brands',
        'featured',
        'price_range',
        'sort',
    ];

    public function addToCart($product_id)
    {
        $total_count = CartManagement::addItemToCart($product_id);

        $this->dispatch('update-cart-count', ['total_count' => $total_count])->to(Navbar::class);

        $this->alert('success', 'Product added to the cart successfully!', [
            'position' => 'top-end',
            'timer' => 3000,
            'toast' => true,
        ]);
    }

    public function render()
    {
        $productsQuery = Product::query()->where('is_visible', true);

        $brands = Brand::where('is_visible', true)->get(['id', 'name', 'slug']);
        $categories = Category::where('is_visible', true)->get(['id', 'name', 'slug']);

        if (!empty($this->selected_categories)) {
            $productsQuery->whereHas('categories', function ($query) {
                $query->whereIn('shop_categories.id', $this->selected_categories);
            });
        }

        if (!empty($this->selected_brands)) {
            $productsQuery->whereIn('shop_brand_id', $this->selected_brands);
        }

        if ($this->featured) {
            $productsQuery->where('featured', true);
        }

        if ($this->price_range > 0) {
            $productsQuery->whereBetween('price', [0, $this->price_range]);
        }

        if ($this->sort == 'latest') {
            $productsQuery->orderBy('published_at', 'desc');
        }

        if ($this->sort == 'price') {
            $productsQuery->orderBy('price', 'asc');
        }

        $products = $productsQuery->paginate(12);

        return view('livewire.products-page', [
            'products' => $products,
            'brands' => $brands,
            'categories' => $categories,
        ]);
    }
}
