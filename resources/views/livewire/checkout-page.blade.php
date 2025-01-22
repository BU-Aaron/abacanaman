<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <h1 class="mb-4 text-2xl font-bold text-gray-800 dark:text-white">
        Checkout
    </h1>
    <p class="mb-6 text-gray-500 dark:text-gray-400">Please confirm the form below to complete your order. This form is
        automatically filled up with your profile information.</p>
    <form wire:submit.prevent="placeOrder">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-12 md:col-span-12 lg:col-span-8">
                <!-- Card -->
                <div class="p-4 bg-white shadow rounded-xl sm:p-7 dark:bg-slate-900">
                    <!-- Shipping Address -->
                    <div class="mb-6">
                        <h2 class="mb-2 text-xl font-bold text-gray-700 underline dark:text-white">
                            Shipping Address
                        </h2>
                        <div class="grid gap-4">
                            @foreach($addresses as $address)
                            <div class="relative">
                                <input type="radio" wire:model.live="selected_address_id"
                                    id="address_{{ $address->id }}" value="{{ $address->id }}" class="hidden peer">
                                <label for="address_{{ $address->id }}"
                                    class="block p-4 bg-white border rounded-lg cursor-pointer peer-checked:border-amber-500 peer-checked:ring-1 peer-checked:ring-amber-500 dark:bg-gray-800 dark:border-gray-700">
                                    <div class="flex justify-between">
                                        <div>
                                            <p class="font-semibold text-gray-800 dark:text-white">
                                                {{ Auth::user()->name }}
                                            </p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                                {{ $address->address }}
                                            </p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                                {{ $address->city }}, {{ $address->state }} {{ $address->zip_code }}
                                            </p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                                Phone: {{ Auth::user()->phone_number }}
                                            </p>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            @endforeach
                        </div>
                        @error('selected_address_id')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4 text-lg font-semibold">
                        Select Payment Method
                    </div>

                    <ul class="grid w-full gap-6 md:grid-cols-2">
                        <li>
                            <input wire:click="$set('payment_method', 'cod')" wire:model="payment_method"
                                class="hidden peer" id="payment-cod" required type="radio" value="cod" />
                            <label
                                class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-amber-500 peer-checked:border-amber-600 peer-checked:text-amber-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700"
                                for="payment-cod">
                                <div class="block">
                                    <div class="w-full text-lg font-semibold">
                                        Cash on Delivery
                                    </div>
                                </div>
                                <svg aria-hidden="true" class="w-5 h-5 ms-3 rtl:rotate-180" fill="none"
                                    viewBox="0 0 14 10" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 5h12m0 0L9 1m4 4L9 9" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="2">
                                    </path>
                                </svg>
                            </label>
                        </li>
                        <li>
                            <input wire:click="$set('payment_method', 'gcash')" wire:model="payment_method"
                                class="hidden peer" id="payment-gcash" type="radio" value="gcash">
                            <label
                                class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-amber-500 peer-checked:border-amber-600 peer-checked:text-amber-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700"
                                for="payment-gcash">
                                <div class="block">
                                    <div class="w-full text-lg font-semibold">
                                        GCash
                                    </div>
                                </div>
                                <svg aria-hidden="true" class="w-5 h-5 ms-3 rtl:rotate-180" fill="none"
                                    viewBox="0 0 14 10" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 5h12m0 0L9 1m4 4L9 9" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="2">
                                    </path>
                                </svg>
                            </label>
                        </li>
                    </ul>

                    <!-- GCash Details Section -->
                    @if($payment_method === 'gcash')
                    <div class="p-4 mt-6 rounded-lg bg-slate-50">
                        <h2 class="mb-4 text-xl font-bold">GCash Payment Details</h2>
                        <div class="mb-4">
                            <label class="block mb-2 text-gray-700 dark:text-white" for="gcash_reference">
                                Reference Number
                            </label>
                            <input wire:model="gcash_reference"
                                class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white dark:border-none"
                                id="gcash_reference" type="text">
                            @error('gcash_reference')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block mb-2 text-gray-700 dark:text-white" for="gcash_receipt">
                                Upload Receipt Image
                            </label>
                            <input wire:model="gcash_receipt" class="w-full" id="gcash_receipt" type="file"
                                accept="image/*">
                            @error('gcash_receipt')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror

                            @if ($gcash_receipt)
                            <div class="mt-2">
                                <img src="{{ $gcash_receipt->temporaryUrl() }}" alt="Receipt Preview"
                                    class="object-cover w-32 h-32 rounded">
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    @error('payment_method')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <!-- End Card -->
            </div>
            <div class="col-span-12 md:col-span-12 lg:col-span-4">
                <div class="p-4 bg-white shadow rounded-xl sm:p-7 dark:bg-slate-900">
                    <div class="mb-2 text-xl font-bold text-gray-700 underline dark:text-white">
                        ORDER SUMMARY
                    </div>
                    <div class="flex justify-between mb-2 font-bold">
                        <span>
                            Subtotal
                        </span>
                        <span>
                            PHP {{ number_format($grand_total, 2) }}
                        </span>
                    </div>
                    <div class="flex justify-between mb-2 font-bold">
                        <span>
                            Taxes
                        </span>
                        <span>
                            PHP {{ number_format(0, 2) }}
                        </span>
                    </div>
                    <div class="flex justify-between mb-2 font-bold">
                        <span>
                            Shipping Cost
                        </span>
                        <span>
                            PHP {{ number_format(0, 2) }}
                        </span>
                    </div>
                    <hr class="h-1 my-4 rounded bg-slate-400">
                    <div class="flex justify-between mb-2 font-bold">
                        <span>
                            Grand Total
                        </span>
                        <span>
                            PHP {{ number_format($grand_total, 2) }}
                        </span>
                    </div>
                    </hr>
                </div>
                <button type="submit"
                    class="w-full p-3 mt-4 text-lg text-white bg-green-500 rounded-lg hover:bg-green-600">
                    Place Order
                </button>
                <div class="p-4 mt-4 bg-white shadow rounded-xl sm:p-7 dark:bg-slate-900">
                    <div class="mb-2 text-xl font-bold text-gray-700 underline dark:text-white">
                        BASKET SUMMARY
                    </div>
                    <ul class="divide-y divide-gray-200 dark:divide-gray-700" role="list">
                        @foreach ($cart_items as $ci)
                        <li class="py-3 sm:py-4" wire:key="{{ $ci['product_id'] }}">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <img alt="{{ $ci['product_name'] }}" class="w-12 h-12 rounded-full"
                                        src="{{ $ci['image'] }}">
                                    </img>
                                </div>
                                <div class="flex-1 min-w-0 ms-4">
                                    <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                        {{ $ci['product_name'] }}
                                    </p>
                                    <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                        Quantity: {{ $ci['quantity'] }}
                                    </p>
                                </div>
                                <div
                                    class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                    PHP {{ number_format($ci['unit_amount'] * $ci['quantity'], 2) }}
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
</div>
