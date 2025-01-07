<?php

namespace App\Livewire;

use App\Models\Blog\Post;
use Livewire\Component;
use Livewire\WithPagination;

class BlogPage extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 9;

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $posts = Post::with(['user', 'category'])
            ->where('published_at', '<=', now())
            ->where(function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('content', 'like', '%' . $this->search . '%');
            })
            ->orderBy('published_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.blog-page', compact('posts'));
    }
}
