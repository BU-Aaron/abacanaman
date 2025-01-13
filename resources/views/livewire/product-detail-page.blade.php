<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <section class="overflow-hidden bg-white py-11 font-poppins dark:bg-gray-800">
      <div class="max-w-6xl px-4 py-4 mx-auto lg:py-8 md:px-6">
        <div class="flex flex-wrap -mx-4">
          <div class="w-full mb-8 md:w-1/2 md:mb-0"
               x-data="{ mainImage: '{{ $product->getFirstMediaUrl('product-images') }}' }">
            <div class="sticky top-0 z-40 overflow-hidden">
              <div class="relative mb-6 lg:mb-10 lg:h-2/4 ">
                <img x-bind:src="mainImage" alt="{{ $product->name }}" class="object-cover w-full lg:h-full ">
              </div>
              <div class="flex-wrap hidden md:flex">
                @foreach ($product->getMedia('product-images') as $image)
                  <div class="w-1/2 p-2 sm:w-1/4" x-on:click="mainImage='{{ $image->getUrl() }}'">
                    <img src="{{ $image->getUrl() }}" alt="{{ $product->name }}" class="object-cover w-full lg:h-20 cursor-pointer hover:border hover:border-amber-500">
                  </div>
                @endforeach
              </div>
              <div class="px-6 pb-6 mt-6 border-t border-gray-300 dark:border-gray-400 ">
                <div class="flex flex-wrap items-center mt-6">
                  <span class="mr-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                         class="w-4 h-4 text-gray-700 dark:text-gray-400 bi bi-truck" viewBox="0 0 16 16">
                      <path d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5v-7zm1.294 7.456A1.999 1.999 0 0 1 4.732 11h5.536a2.01 2.01 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456zM12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12v4zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z">
                      </path>
                    </svg>
                  </span>
                  <h2 class="text-lg font-bold text-gray-700 dark:text-gray-400">Free Shipping</h2>
                </div>
              </div>
            </div>
          </div>
          <div class="w-full px-4 md:w-1/2 ">
            <div class="lg:pl-20">
              <div class="mb-8 [&>ul]:list-disc [&>ul]:ml-4">
                <h2 class="max-w-xl mb-6 text-2xl font-bold dark:text-gray-400 md:text-4xl">{{ $product->name }}</h2>
                <p class="inline-block mb-6 text-4xl font-bold text-gray-700 dark:text-gray-400">
                    @if($product->has_active_discount)
                        <span>PHP {{ number_format($product->discounted_price, 2) }}</span>
                        <span class="text-base font-normal text-gray-500 line-through dark:text-gray-400">
                            PHP {{ number_format($product->price, 2) }}
                        </span>
                        <span class="ml-2 text-sm text-red-500">
                            -{{ $product->active_discount_percentage }}%
                        </span>
                    @else
                        <span>PHP {{ number_format($product->price, 2) }}</span>
                    @endif
                </p>
                <p class="max-w-md text-gray-700 dark:text-gray-400">
                  {!! $product->description !!}
                </p>
              </div>
              <div class="w-32 mb-8 ">
                <label for="quantity" class="w-full pb-1 text-xl font-semibold text-gray-700 border-b border-amber-300 dark:border-gray-600 dark:text-gray-400">Quantity</label>
                <div class="relative flex flex-row w-full h-10 mt-6 bg-transparent rounded-lg">
                  <button wire:click='decreaseQty'
                          class="w-20 h-full text-gray-600 bg-gray-300 rounded-l outline-none cursor-pointer dark:hover:bg-gray-700 dark:text-gray-400 hover:text-gray-700 dark:bg-gray-900 hover:bg-gray-400">
                    <span class="m-auto text-2xl font-thin">-</span>
                  </button>
                  <input type="number" wire:model='quantity' readonly
                         class="flex items-center w-full font-semibold text-center text-gray-700 placeholder-gray-700 bg-gray-300 outline-none dark:text-gray-400 dark:placeholder-gray-400 dark:bg-gray-900 focus:outline-none text-md hover:text-black"
                         placeholder="1">
                  <button wire:click='increaseQty'
                          class="w-20 h-full text-gray-600 bg-gray-300 rounded-r outline-none cursor-pointer dark:hover:bg-gray-700 dark:text-gray-400 dark:bg-gray-900 hover:text-gray-700 hover:bg-gray-400">
                    <span class="m-auto text-2xl font-thin">+</span>
                  </button>
                </div>
              </div>
              <div class="flex flex-wrap items-center gap-4">
                <button wire:click='addToCart({{ $product->id }})'
                        class="w-full p-4 bg-amber-500 rounded-md lg:w-2/5 dark:text-gray-200 text-gray-50 hover:bg-amber-600 dark:bg-amber-500 dark:hover:bg-amber-700">
                  <span wire:loading.remove>Add to cart</span>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Reviews Section -->
      <div class="max-w-2xl mx-auto mt-12">
        <h2 class="text-2xl font-bold mb-4 dark:text-gray-200">Customer Reviews</h2>

        <!-- Display Existing Reviews -->
        @forelse($product->comments as $comment)
          <div class="mb-6 p-4 border rounded dark:border-gray-700">
            <div class="flex items-center justify-between mb-2">
              <span class="font-semibold text-gray-800 dark:text-gray-200">{{ $comment->user->name }}</span>
              <div class="flex">
                @for ($i = 1; $i <= 5; $i++)
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ $i <= $comment->rating ? 'text-amber-500' : 'text-gray-300' }}" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.972a1 1 0 00.95.69h4.164c.969 0 1.371 1.24.588 1.81l-3.37 2.45a1 1 0 00-.364 1.118l1.286 3.972c.3.921-.755 1.688-1.538 1.118l-3.37-2.45a1 1 0 00-1.176 0l-3.37 2.45c-.783.57-1.838-.197-1.538-1.118l1.286-3.972a1 1 0 00-.364-1.118L2.651 9.399c-.783-.57-.38-1.81.588-1.81h4.164a1 1 0 00.95-.69l1.286-3.972z" />
                  </svg>
                @endfor
              </div>
            </div>
            <p class="text-gray-700 dark:text-gray-300">{{ $comment->content }}</p>
            <span class="text-sm text-gray-500 dark:text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
          </div>
        @empty
          <p class="text-gray-500 dark:text-gray-400">No reviews yet. Be the first to review this product!</p>
        @endforelse

        <!-- Review Submission Form -->
        @auth
          @if(auth()->user()->role === 'buyer')
            <div class="mt-8 p-4 border rounded dark:border-gray-700">
              <h3 class="text-xl font-semibold mb-4 dark:text-gray-200">Leave a Review</h3>
              <form wire:submit.prevent="submitReview">
                <div class="mb-4">
                  <label class="block text-gray-700 dark:text-gray-300 mb-2" for="rating">Rating</label>
                  <div class="flex flex-row-reverse justify-end items-center">
                    @for ($i = 5; $i >= 1; $i--)
                      <input
                        id="rating-{{ $i }}"
                        type="radio"
                        wire:model.defer="rating"
                        value="{{ $i }}"
                        class="peer hidden"
                        name="rating"
                      >
                      <label
                        for="rating-{{ $i }}"
                        class="cursor-pointer text-gray-300 dark:text-neutral-600 peer-checked:text-yellow-400 dark:peer-checked:text-yellow-600"
                      >
                        <svg class="w-5 h-5 inline" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                          <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                        </svg>
                      </label>
                    @endfor
                  </div>
                  @error('rating') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                  <label class="block text-gray-700 dark:text-gray-300 mb-2" for="comment">Comment</label>
                  <textarea wire:model.defer="comment" id="comment" rows="4" class="w-full px-3 py-2 border rounded"></textarea>
                  @error('comment') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="px-4 py-2 bg-amber-500 text-white rounded hover:bg-amber-600">Submit Review</button>
              </form>
            </div>
          @endif
        @else
          <p class="mt-4 text-gray-500 dark:text-gray-400">Please <a href="{{ route('login') }}" class="text-amber-500">login</a> to leave a review.</p>
        @endauth
      </div>
    </section>
</div>
