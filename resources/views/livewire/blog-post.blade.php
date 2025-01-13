<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <article class="rounded-lg overflow-hidden">
        @if($post->image)
            <div class="relative h-64 w-full">
                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="absolute inset-0 w-full h-full object-cover">
            </div>
        @endif
        <div class="p-8">
            <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white mb-4">
                {{ $post->title }}
            </h1>
            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mb-6">
                <div class="flex items-center space-x-2">
                    <span>By {{ $post->user->name }}</span>
                </div>
                <span class="mx-2">•</span>
                <div class="flex items-center space-x-2">
                    <span>{{ $post->published_at->format('M d, Y') }}</span>
                </div>
            </div>
            <div class="prose prose-lg dark:prose-dark">
                {!! Str::markdown($post->content) !!}
            </div>
        </div>
    </article>
</div>
