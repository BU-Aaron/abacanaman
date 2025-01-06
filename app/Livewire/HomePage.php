<?php

namespace App\Livewire;

use App\Models\Shop\Seller;
use App\Models\Shop\Category;
use App\Models\Comment;
use App\Models\Shop\Product;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Home - Abacanaman')]

class HomePage extends Component
{
    public $sellers;
    public $categories;
    public $recentComments;

    public function render()
    {
        // Fetch active sellers, ensuring at least 6
        $this->sellers = Seller::take(6)->get();

        // Fetch active categories
        $this->categories = Category::where('is_visible', 1)->get();

        // Fetch recent product comments (reviews)
        $this->recentComments = Comment::with('user', 'commentable')
            ->where('commentable_type', Product::class)
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.home-page', [
            'sellers' => $this->sellers,
            'categories' => $this->categories,
            'recentComments' => $this->recentComments,
        ]);
    }
}
