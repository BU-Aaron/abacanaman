<?php

namespace App\Livewire;

use App\Models\Shop\Seller;
use App\Models\Shop\Category;
use App\Models\Comment;
use App\Models\Shop\Product;
use App\Models\Shop\Promotion;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Home - Abacanaman')]

class HomePage extends Component
{
    public $sellers;
    public $categories;
    public $recentComments;
    public $randomPromotion;

    public function render()
    {
        // Fetch active sellers, ensuring at least 6
        //  if verified
        $this->sellers = Seller::take(6)->where('is_verified', 1)->get();

        // Fetch active categories
        $this->categories = Category::where('is_visible', 1)->get();

        // Fetch recent product comments (reviews)
        $this->recentComments = Comment::with('user', 'commentable')
            ->where('commentable_type', Product::class)
            ->latest()
            ->take(5)
            ->get();

        // Fetch a random active promotion with its products
        $this->randomPromotion = Promotion::where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->with(['products' => function ($query) {
                $query->where('is_visible', true)
                    ->with('media')
                    ->take(4);
            }])
            ->inRandomOrder()
            ->first();

        return view('livewire.home-page', [
            'sellers' => $this->sellers,
            'categories' => $this->categories,
            'recentComments' => $this->recentComments,
            'randomPromotion' => $this->randomPromotion,
        ]);
    }
}
