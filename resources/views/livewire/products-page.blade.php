<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <div class="flex flex-col lg:flex-row gap-4">
        <!-- Filters Sidebar -->
        <div class="w-full lg:w-1/4">
            <!-- Seller Filter -->
            <div class="p-4 mb-5 bg-white border border-gray-200 dark:bg-gray-900 dark:border-gray-900">
                <h2 class="text-2xl font-bold dark:text-gray-400">Sellers</h2>
                <div class="w-16 pb-2 mb-6 border-b border-rose-600 dark:border-gray-400"></div>
                <ul>
                    @foreach ($sellers as $seller)
                        <li class="mb-4" wire:key="{{ $seller->id }}">
                            <label for="seller_{{ $seller->id }}" class="flex items-center dark:text-gray-300">
                                <input type="checkbox" wire:model.live="selected_sellers" id="seller_{{ $seller->id }}" value="{{ $seller->id }}" class="w-4 h-4 mr-2">
                                <span class="text-lg dark:text-gray-400">{{ $seller->store_name }}</span>
                            </label>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Category Filter -->
            <div class="p-4 mb-5 bg-white border border-gray-200 dark:bg-gray-900 dark:border-gray-900">
                <h2 class="text-2xl font-bold dark:text-gray-400">Categories</h2>
                <div class="w-16 pb-2 mb-6 border-b border-rose-600 dark:border-gray-400"></div>
                <ul>
                    @foreach ($categories as $category)
                        <li class="mb-4" wire:key="{{ $category->id }}">
                            <label for="category_{{ $category->slug }}" class="flex items-center dark:text-gray-300">
                                <input type="checkbox" wire:model.live="selected_categories" id="category_{{ $category->slug }}" value="{{ $category->id }}" class="w-4 h-4 mr-2">
                                <span class="text-lg dark:text-gray-400">{{ $category->name }}</span>
                            </label>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Product Status Filter -->
            <div class="p-4 mb-5 bg-white border border-gray-200 dark:bg-gray-900 dark:border-gray-900">
                <h2 class="text-2xl font-bold dark:text-gray-400">Product Status</h2>
                <div class="w-16 pb-2 mb-6 border-b border-rose-600 dark:border-gray-400"></div>
                <ul>
                    <li class="mb-4">
                        <label for="featured" class="flex items-center dark:text-gray-300">
                            <input type="checkbox" id="featured" wire:model.live="featured" value="1" class="w-4 h-4 mr-2">
                            <span class="text-lg dark:text-gray-400">Featured Products</span>
                        </label>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Products Listing -->
        <div class="w-full lg:w-3/4">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse ($products as $product)
                    <div class="border border-gray-300 dark:border-gray-700">
                        <div class="relative bg-gray-200">
                            <a href="{{ route('product-details', $product->slug) }}" class="">
                                @if($product->getFirstMediaUrl('product-images'))
                                    <img src="{{ $product->getFirstMediaUrl('product-images') }}" alt="{{ $product->name }}" class="object-cover w-full h-56 mx-auto">
                                @else
                                    <img src="{{ asset('images/default-product.jpg') }}" alt="{{ $product->name }}" class="object-cover w-full h-56 mx-auto">
                                @endif
                            </a>
                        </div>
                        <div class="p-4">
                            <h3 class="text-lg font-semibold dark:text-gray-400">{{ $product->name }}</h3>
                            <p class="text-xl">
                                <span class="text-green-600 dark:text-green-600">PHP {{ number_format($product->price, 2) }}</span>
                                {{-- @if($product->old_price)
                                    <span class="text-base font-normal text-gray-500 line-through dark:text-gray-400">PHP {{ number_format($product->old_price, 2) }}</span>
                                @endif --}}
                            </p>
                            <div class="mt-2">
                                <a href="{{ route('seller.page', $product->seller->id) }}" class="text-amber-500 hover:underline">View Seller</a>
                            </div>
                        </div>
                        <div class="flex justify-center p-4 border-t border-gray-300 dark:border-gray-700">
                            <button wire:click="addToCart({{ $product->id }})" class="w-full p-2 bg-amber-500 text-white rounded hover:bg-amber-600">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 dark:text-gray-400">No products found.</p>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
