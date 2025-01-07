<?php

namespace App\Livewire;

use App\Models\Blog\Post;
use Livewire\Component;

class BlogPost extends Component
{
    public $slug;
    public $post;

    public function mount($slug)
    {
        $this->slug = $slug;
        $this->post = Post::with(['user', 'category'])->where('slug', $slug)->firstOrFail();
    }

    public function render()
    {
        return view('livewire.blog-post');
    }
}
