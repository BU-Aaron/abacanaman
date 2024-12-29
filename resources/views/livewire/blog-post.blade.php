<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <article class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        @if($post->image)
            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-64 object-cover rounded-lg mb-6">
        @endif
        <h1 class="text-4xl font-bold mb-4">{{ $post->title }}</h1>
        <div class="text-gray-500 dark:text-gray-400 mb-6">
            {{-- By {{ $post->author->name }} in <a href="{{ route('blog.category', $post->category->slug) }}" class="text-amber-600 hover:text-amber-800">{{ $post->category->name }}</a> on {{ $post->published_at->format('M d, Y') }} --}}
            By John Doe on {{ $post->published_at->format('M d, Y') }}
        </div>
        <div class="prose dark:prose-dark">
            {!! $post->content !!}
        </div>
    </article>
</div>
