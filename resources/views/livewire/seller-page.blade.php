<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <!-- Seller Details -->
    <div class="flex flex-col items-center p-6 bg-white rounded-lg shadow-md dark:bg-gray-800">
        @if($seller->store_logo)
        <img src="{{ Storage::url($seller->store_logo) }}" alt="{{ $seller->store_name }}"
            class="object-cover w-32 h-32 mb-4 rounded-full">
        @else
        <img src="https://placehold.co/600x400" alt="{{ $seller->store_name }}"
            class="object-cover w-32 h-32 mb-4 rounded-full">
        @endif
        <h2 class="text-3xl font-bold dark:text-gray-200">{{ $seller->user->name }}</h2>
        <p class="mt-2 text-gray-600 dark:text-gray-400">{{ $seller->store_description }}</p>
        <p class="mt-2 text-gray-600 dark:text-gray-400">Contact: {{ $seller->contact_number ?? 'N/A' }}</p>
        <div class="mt-4">
            <a href="{{ route('buyer.chat', ['seller_id' => $seller->id]) }}"
                class="flex items-center px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path
                        d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.06 9.06 0 01-2-.294M3 12a9.06 9.06 0 012-.294c4.97 0 9 3.582 9 8 0 .3-.03.59-.086.874M15 16l-3-3-3 3" />
                </svg>
                Chat with Seller
            </a>
        </div>
    </div>

    <!-- Seller's Products -->
    <div class="mt-10">
        <h3 class="text-2xl font-bold dark:text-gray-200">Products by {{ $seller->store_name }}</h3>
        <div class="grid grid-cols-1 gap-6 mt-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            @forelse ($products as $product)
            <div class="border border-gray-300 dark:border-gray-700">
                <div class="relative bg-gray-200">
                    <a href="{{ route('product-details', $product->slug) }}">
                        @if($product->getFirstMediaUrl('product-images'))
                        <img src="{{ $product->getFirstMediaUrl('product-images') }}" alt="{{ $product->name }}"
                            class="object-cover w-full h-56 mx-auto">
                        @else
                        <img src="https://placehold.co/600x400" alt="{{ $product->name }}"
                            class="object-cover w-full h-56 mx-auto">
                        @endif
                    </a>
                </div>
                <div class="p-4">
                    <h4 class="text-lg font-semibold dark:text-gray-400">{{ $product->name }}</h4>
                    <p class="text-xl">
                        @if($product->has_total_active_discount)
                        <span class="text-green-600 dark:text-green-600">
                            PHP {{ number_format($product->discounted_price, 2) }}
                        </span>
                        <span class="text-base font-normal text-gray-500 line-through dark:text-gray-400">
                            PHP {{ number_format($product->price, 2) }}
                        </span>
                        <span class="block text-sm text-red-500">
                            -{{ $product->total_discount_percentage }}% off
                        </span>
                        @else
                        <span class="text-green-600 dark:text-green-600">
                            PHP {{ number_format($product->price, 2) }}
                        </span>
                        @endif
                    </p>
                </div>
                <div class="flex justify-center p-4 border-t border-gray-300 dark:border-gray-700">
                    <button wire:click="addToCart({{ $product->id }})"
                        class="w-full p-2 text-white rounded bg-amber-500 hover:bg-amber-600">
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
