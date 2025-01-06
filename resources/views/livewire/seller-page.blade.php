<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <!-- Seller Details -->
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md flex flex-col items-center">
        @if($seller->store_logo)
            <img src="https://placehold.co/600x400" alt="{{ $seller->store_name }}" class="w-32 h-32 mb-4 rounded-full object-cover">
        @else
            <img src="https://placehold.co/600x400" alt="{{ $seller->store_name }}" class="w-32 h-32 mb-4 rounded-full object-cover">
        @endif
        <h2 class="text-3xl font-bold dark:text-gray-200">{{ $seller->store_name }}</h2>
        <p class="text-gray-600 dark:text-gray-400 mt-2">{{ $seller->store_description }}</p>
        <p class="text-gray-600 dark:text-gray-400 mt-2">Contact: {{ $seller->contact_number ?? 'N/A' }}</p>
        {{-- <div class="mt-4">
            <a href="{{ route('buyer.chat', ['seller_id' => $seller->id]) }}" class="flex items-center px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.06 9.06 0 01-2-.294M3 12a9.06 9.06 0 012-.294c4.97 0 9 3.582 9 8 0 .3-.03.59-.086.874M15 16l-3-3-3 3" />
                </svg>
                Chat with Seller
            </a>
        </div> --}}
    </div>

    <!-- Seller's Products -->
    <div class="mt-10">
        <h3 class="text-2xl font-bold dark:text-gray-200">Products by {{ $seller->store_name }}</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-6">
            @forelse ($products as $product)
                <div class="border border-gray-300 dark:border-gray-700">
                    <div class="relative bg-gray-200">
                        <a href="{{ route('product-details', $product->slug) }}" class="">
                            @if($product->getFirstMediaUrl('product-images'))
                                <img src="{{ $product->getFirstMediaUrl('product-images') }}" alt="{{ $product->name }}" class="object-cover w-full h-56 mx-auto">
                            @else
                                <img src="https://placehold.co/600x400" alt="{{ $product->name }}" class="object-cover w-full h-56 mx-auto">
                            @endif
                        </a>
                    </div>
                    <div class="p-4">
                        <h4 class="text-lg font-semibold dark:text-gray-400">{{ $product->name }}</h4>
                        <p class="text-xl">
                            <span class="text-green-600 dark:text-green-600">PHP {{ number_format($product->price, 2) }}</span>
                            @if($product->old_price)
                                <span class="text-base font-normal text-gray-500 line-through dark:text-gray-400">PHP {{ number_format($product->old_price, 2) }}</span>
                            @endif
                        </p>
                    </div>
                    <div class="flex justify-center p-4 border-t border-gray-300 dark:border-gray-700">
                        <button wire:click="addToCart({{ $product->id }})" class="w-full p-2 bg-amber-500 text-white rounded hover:bg-amber-600">
                            Add to Cart
                        </button>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 dark:text-gray-400">This seller has no products listed.</p>
            @endforelse
        </div>
    </div>
</div>
