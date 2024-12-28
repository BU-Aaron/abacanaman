<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row">
        <div class="md:w-1/2">
            @if($product->getFirstMediaUrl('product-images'))
                <img src="{{ $product->getFirstMediaUrl('product-images') }}" alt="{{ $product->name }}" class="w-full h-96 object-cover rounded-lg">
            @else
                <img src="{{ asset('images/default-product.jpg') }}" alt="{{ $product->name }}" class="w-full h-96 object-cover rounded-lg">
            @endif
        </div>
        <div class="md:w-1/2 md:pl-8 mt-6 md:mt-0">
            <h1 class="text-3xl font-bold mb-4">{{ $product->name }}</h1>
            <p class="text-gray-700 mb-4">{{ $product->description }}</p>
            <div class="flex items-center mb-4">
                <span class="text-green-600 font-bold text-xl">PHP {{ number_format($product->price, 2) }}</span>
                @if($product->old_price)
                    <span class="text-gray-500 line-through ml-2">PHP {{ number_format($product->old_price, 2) }}</span>
                @endif
            </div>
            <a href="#" class="inline-block bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">Add to Cart</a>
        </div>
    </div>
</div>
