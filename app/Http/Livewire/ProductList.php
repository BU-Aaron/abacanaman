<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Shop\Product;
use Livewire\WithPagination;

class ProductList extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedCategory = null;

    protected $paginationTheme = 'tailwind';

    protected $listeners = ['categorySelected' => 'filterByCategory'];

    protected $queryString = ['selectedCategory'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function filterByCategory($categoryId)
    {
        $this->selectedCategory = $categoryId;
        $this->resetPage();
    }

    public function render()
    {
        $query = Product::query()
            ->where('is_visible', true)
            ->when($this->search, function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            });

        if ($this->selectedCategory) {
            $query->whereHas('categories', function ($q) {
                $q->where('shop_categories.id', $this->selectedCategory);
            });
        }

        $products = $query->paginate(12);

        return view('livewire.product-list', [
            'products' => $products,
        ]);
    }
}
