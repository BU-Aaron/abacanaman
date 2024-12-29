<?php

namespace App\Livewire;

use App\Models\Shop\Category;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Categories - ByteWebster')]
class CategoriesPage extends Component
{
    public function render()
    {
        $categories = Category::get();
        return view('livewire.categories-page', compact('categories'));
    }
}
