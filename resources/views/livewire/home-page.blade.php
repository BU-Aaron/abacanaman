<div>

    <div class="w-full bg-gradient-to-r from-amber-200 to-cyan-200 py-20 px-4 sm:px-6 lg:px-8 mx-auto">
        <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Grid -->
            <div class="grid md:grid-cols-2 gap-4 md:gap-8 xl:gap-20 md:items-center">
                <div>
                    <h1 class="block text-3xl font-bold text-gray-800 sm:text-4xl lg:text-6xl lg:leading-tight dark:text-white">Explore the beauty of <span class="text-amber-600">Abaca Creations</span></h1>
                    <p class="mt-3 text-lg text-gray-800 dark:text-gray-400">Discover a wide range of eco-friendly and handcrafted abaca products, including bags, mats, decor, and more.</p>

                    <!-- Buttons -->
                    <div class="mt-7 grid gap-3 w-full sm:inline-flex">
                        <a wire:navigate.hover class="py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-amber-600 text-white hover:bg-amber-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="/products">
                            Shop Now
                            <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m9 18 6-6-6-6" />
                            </svg>
                        </a>
                        <a class="py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="/contact">
                            Contact Us
                        </a>
                    </div>
                    <!-- End Buttons -->
                </div>
                <!-- End Col -->

                <div class="relative ms-4">
                    <img class="w-full rounded-md" src="{{ asset('images/raw-abaca.jpg') }}" alt="Image Description">
                </div>
                <!-- End Col -->
            </div>
            <!-- End Grid -->
        </div>
    </div>

<!-- Are You a Buyer or a Seller Section Start -->
<div class="w-full py-20 px-4 sm:px-6 lg:px-8 bg-gray-50 dark:bg-gray-900 ">
    <div class="max-w-xl mx-auto text-center">
        <div class="text-center ">
            <div class="relative flex flex-col items-center">
              <h1 class="text-5xl font-bold dark:text-gray-200"> Are you a <span class="text-amber-500"> Buyer </span> or <span class="text-amber-500"> Seller?
                </span> </h1>
              <div class="flex w-40 mt-2 mb-6 overflow-hidden rounded">
                <div class="flex-1 h-2 bg-amber-200">
                </div>
                <div class="flex-1 h-2 bg-amber-400">
                </div>
                <div class="flex-1 h-2 bg-amber-600">
                </div>
              </div>
            </div>
            <p class="mb-12 text-base text-center text-gray-500">
                Whether you're looking to purchase eco-friendly abaca products or want to sell your own creations, we've got you covered.
            </p>
          </div>
        <div class="flex justify-center space-x-4">
            <a href="/login" class="py-3 px-6 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition flex items-center">
                <i class="fas fa-shopping-cart mr-2"></i> I'm a Buyer
            </a>
            <a href="/seller/login" class="py-3 px-6 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center">
                <i class="fas fa-store mr-2"></i> I'm a Seller
            </a>

        </div>
    </div>
</div>
<!-- Are You a Buyer or a Seller Section End -->

    {{-- Sellers Section Start --}}

    <section class="py-20">
        <div class="max-w-xl mx-auto">
          <div class="text-center ">
            <div class="relative flex flex-col items-center">
              <h1 class="text-5xl font-bold dark:text-gray-200"> Browse <span class="text-amber-500"> Our Sellers
                </span> </h1>
              <div class="flex w-40 mt-2 mb-6 overflow-hidden rounded">
                <div class="flex-1 h-2 bg-amber-200">
                </div>
                <div class="flex-1 h-2 bg-amber-400">
                </div>
                <div class="flex-1 h-2 bg-amber-600">
                </div>
              </div>
            </div>
            <p class="mb-12 text-base text-center text-gray-500">
              Meet our trusted sellers who offer a variety of high-quality abaca products.
              Browse their stores and find the perfect items for your needs.
            </p>
          </div>
        </div>
        <div class="justify-center max-w-6xl px-4 py-4 mx-auto lg:py-0">
          <div class="grid grid-cols-1 gap-6 lg:grid-cols-4 md:grid-cols-2">

            @foreach ($sellers as $seller)

              <div class="bg-white rounded-lg shadow-md dark:bg-gray-800" wire:key="{{ $seller->id }}">
                <a href="{{ route('seller.page', $seller->id) }}" class="">
                  <img src="https://placehold.co/600x400" alt="{{ $seller->store_name }}" class="object-cover w-full h-64 rounded-t-lg">
                </a>
                <div class="p-5 text-center">
                  <a href="{{ route('seller.page', $seller->id) }}" class="text-2xl font-bold tracking-tight text-gray-900 dark:text-gray-300">
                    {{ $seller->user->name }}
                  </a>
                </div>
              </div>

            @endforeach

          </div>
        </div>
    </section>

    {{-- Sellers Section End --}}



    {{-- Category Section Start --}}

    <div class="bg-orange-200 py-20">
        <div class="max-w-xl mx-auto">
          <div class="text-center ">
            <div class="relative flex flex-col items-center">
              <h1 class="text-5xl font-bold dark:text-gray-200"> Browse <span class="text-amber-500"> Categories
                </span> </h1>
              <div class="flex w-40 mt-2 mb-6 overflow-hidden rounded">
                <div class="flex-1 h-2 bg-amber-200">
                </div>
                <div class="flex-1 h-2 bg-amber-400">
                </div>
                <div class="flex-1 h-2 bg-amber-600">
                </div>
              </div>
            </div>
            <p class="mb-12 text-base text-center text-gray-500">
              Explore our diverse range of categories to find exactly what you're looking for.
              From bags to home decor, we've got you covered.
            </p>
          </div>
        </div>

        <div class="max-w-[85rem] px-4 sm:px-6 lg:px-8 mx-auto">
          <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-6">

            @foreach ($categories as $category)

              <a class="group flex flex-col bg-white border shadow-sm rounded-xl hover:shadow-md transition dark:bg-slate-900 dark:border-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="/products?selected_categories[0]={{ $category->id }}" wire:key="{{ $category->id }}">
                <div class="p-4 md:p-5">
                  <div class="flex justify-between items-center">
                    <div class="flex items-center">
                      <div class="ms-3">
                        <h3 class="group-hover:text-amber-600 font-semibold text-gray-800 dark:group-hover:text-gray-400 dark:text-gray-200">
                          {{ $category->name }}
                        </h3>
                      </div>
                    </div>
                    <div class="ps-3">
                      <svg class="flex-shrink-0 w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m9 18 6-6-6-6" />
                      </svg>
                    </div>
                  </div>
                </div>
              </a>

            @endforeach

          </div>
        </div>

    </div>

    {{-- Category Section End --}}


    {{-- Reviews Section Start --}}

    <section class="py-14 font-poppins dark:bg-gray-800">
        <div class="max-w-6xl px-4 py-6 mx-auto lg:py-4 md:px-6">
            <div class="max-w-xl mx-auto">
                <div class="text-center ">
                    <div class="relative flex flex-col items-center">
                        <h1 class="text-5xl font-bold dark:text-gray-200"> Customer <span class="text-amber-500"> Reviews
                            </span> </h1>
                        <div class="flex w-40 mt-2 mb-6 overflow-hidden rounded">
                            <div class="flex-1 h-2 bg-amber-200"></div>
                            <div class="flex-1 h-2 bg-amber-400"></div>
                            <div class="flex-1 h-2 bg-amber-600"></div>
                        </div>
                    </div>
                    <p class="mb-12 text-base text-center text-gray-500">
                        Hear from our satisfied customers who love our abaca products.
                        Your feedback helps us improve and serve you better.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                @foreach ($recentComments as $comment)
                    <div class="py-6 bg-white rounded-md shadow dark:bg-gray-900">
                        <div class="flex flex-wrap items-center justify-between pb-4 mb-6 space-x-2 border-b dark:border-gray-700">
                            <div class="flex items-center px-6 mb-2 md:mb-0">
                                <div>
                                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-300">
                                        {{ $comment->user->name }}
                                    </h2>
                                </div>
                            </div>
                            <p class="px-6 text-base font-medium text-gray-600 dark:text-gray-400">
                                Joined {{ $comment->user->created_at->format('d, M, Y') }}
                            </p>
                        </div>
                        <p class="px-6 mb-6 text-base text-gray-500 dark:text-gray-400">
                            {{ $comment->content }}
                        </p>
                        <div class="flex flex-wrap justify-between pt-4 border-t dark:border-gray-700">
                            <div class="flex px-6 mb-2 md:mb-0">
                                <ul class="flex items-center justify-start mr-4">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <li>
                                            <a href="#">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="w-4 mr-1 {{ $i <= $comment->rating ? 'text-amber-500' : 'text-gray-300' }} bi bi-star-fill" viewBox="0 0 16 16">
                                                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
                                                </svg>
                                            </a>
                                        </li>
                                    @endfor
                                </ul>
                                <h2 class="text-sm text-gray-500 dark:text-gray-400">
                                    Rating:
                                    <span class="font-semibold text-gray-600 dark:text-gray-300">
                                        {{ $comment->rating }}
                                    </span>
                                </h2>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Reviews Section End --}}

</div>
