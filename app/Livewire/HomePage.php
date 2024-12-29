<?php

namespace App\Livewire;

use App\Models\Shop\Brand;
use App\Models\Shop\Category;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Home - Abacanaman')]

class HomePage extends Component
{
    public function render()
    {
        $brands = Brand::where('is_active', 1)->get();
        $categories = Category::where('is_active', 1)->get();

        return view('livewire.home-page', compact('brands', 'categories'));
    }
}
