<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <input
            type="text"
            wire:model.debounce.500ms="search"
            placeholder="Search products..."
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
        />
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($products as $product)
            <div class="border rounded-lg overflow-hidden shadow hover:shadow-lg transition-shadow duration-300">
                @if($product->getFirstMediaUrl('product-images'))
                    <img src="{{ $product->getFirstMediaUrl('product-images') }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                @else
                    <img src="{{ asset('images/default-product.jpg') }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                @endif
                <div class="p-4">
                    <h2 class="text-lg font-semibold mb-2">{{ $product->name }}</h2>
                    <p class="text-gray-700 mb-4">{{ Str::limit($product->description, 100) }}</p>
                    <div class="flex justify-between items-center">
                        <span class="text-green-600 font-bold">PHP {{ number_format($product->price, 2) }}</span>
                        <a href="{{ route('product.show', $product) }}" class="text-sm text-green-500 hover:underline">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center text-gray-500">
                No products found.
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $products->links() }}
    </div>
</div>
