<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-4xl font-bold mb-8 text-center">Blog</h1>

    <!-- Blog Posts -->
    <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
        @forelse($posts as $post)
            <a href="{{ route('blog.post', $post->slug) }}" class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                @if($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
                @endif
                <div class="p-6">
                    <h2 class="text-2xl font-semibold mb-2">{{ $post->title }}</h2>
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        By {{ $post->user->name }} on {{ $post->published_at->format('M d, Y') }}
                    </div>
                </div>
            </a>
        @empty
            <p class="text-center text-gray-500 dark:text-gray-400">No blog posts found.</p>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $posts->links() }}
    </div>
</div>
