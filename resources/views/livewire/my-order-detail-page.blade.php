<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <h1 class="text-4xl font-bold text-slate-500">Order Details</h1>

    {{-- Stepper UI --}}
    @php
    $steps = [
    ['status' => 'new', 'label' => 'New'],
    ['status' => 'processing', 'label' => 'Processing'],
    ['status' => 'shipped', 'label' => 'Shipped'],
    ['status' => 'delivered', 'label' => 'Delivered'],
    ];

    $currentStatus = $order->status->value;
    $currentIndex = collect($steps)->search(fn($step) => $step['status'] === $currentStatus);
    @endphp

    <div class="my-8">
        <div class="flex items-center justify-center">
            @foreach ($steps as $index => $step)
            <div class="flex flex-col items-center">
                <!-- Step Indicator -->
                <div class="flex items-center">
                    <div class="flex flex-col items-center">
                        <!-- Step Circle -->
                        <div class="flex items-center justify-center w-10 h-10 rounded-full
                                    @if ($index < $currentIndex)
                                        bg-green-500 text-white
                                    @elseif ($index === $currentIndex)
                                        bg-amber-500 text-white
                                    @else
                                        bg-gray-300 text-gray-600
                                    @endif">
                            {{ $index + 1 }}
                        </div>
                        <!-- Step Label -->
                        <div class="mt-2 text-sm font-medium text-center text-gray-700 dark:text-gray-300">
                            {{ $step['label'] }}
                        </div>
                    </div>
                    <!-- Connector Line -->
                    @if ($index < count($steps) - 1) <div class="w-16 h-1
                                    @if ($index < $currentIndex)
                                        bg-green-500
                                    @else
                                        bg-gray-300
                                    @endif
                                    ">
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Optional: Handle Cancelled Status -->
@if ($order->status->value === 'cancelled')
<div class="mt-4 font-semibold text-center text-red-500">
    Your order has been cancelled.
</div>
@endif

<!-- Grid -->
<div class="grid gap-4 mt-5 sm:grid-cols-2 lg:grid-cols-4 sm:gap-6">
    <!-- Card -->
    <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-slate-900 dark:border-gray-800">
        <div class="flex p-4 md:p-5 gap-x-4">
            <div
                class="flex-shrink-0 flex justify-center items-center size-[46px] bg-gray-100 rounded-lg dark:bg-gray-800">
                <svg class="flex-shrink-0 text-gray-600 size-5 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                </svg>
            </div>

            <div class="grow">
                <div class="flex items-center gap-x-2">
                    <p class="text-xs tracking-wide text-gray-500 uppercase">
                        Customer
                    </p>
                </div>
                <div class="flex items-center mt-1 gap-x-2">
                    <div>{{ $order->user->name }}</div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Card -->

    <!-- Card -->
    <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-slate-900 dark:border-gray-800">
        <div class="flex p-4 md:p-5 gap-x-4">
            <div
                class="flex-shrink-0 flex justify-center items-center size-[46px] bg-gray-100 rounded-lg dark:bg-gray-800">
                <svg class="flex-shrink-0 text-gray-600 size-5 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M5 22h14" />
                    <path d="M5 2h14" />
                    <path d="M17 22v-4.172a2 2 0 0 0-.586-1.414L12 12l-4.414 4.414A2 2 0 0 0 7 17.828V22" />
                    <path d="M7 2v4.172a2 2 0 0 0 .586 1.414L12 12l4.414-4.414A2 2 0 0 0 17 6.172V2" />
                </svg>
            </div>

            <div class="grow">
                <div class="flex items-center gap-x-2">
                    <p class="text-xs tracking-wide text-gray-500 uppercase">
                        Order Date
                    </p>
                </div>
                <div class="flex items-center mt-1 gap-x-2">
                    <h3 class="text-xl font-medium text-gray-800 dark:text-gray-200">
                        {{ $order->created_at->format('d-m-Y') }}
                    </h3>
                </div>
            </div>
        </div>
    </div>
    <!-- End Card -->

    <!-- Card -->
    <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-slate-900 dark:border-gray-800">
        <div class="flex p-4 md:p-5 gap-x-4">
            <div
                class="flex-shrink-0 flex justify-center items-center size-[46px] bg-gray-100 rounded-lg dark:bg-gray-800">
                <svg class="flex-shrink-0 text-gray-600 size-5 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 11V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h6" />
                    <path d="m12 12 4 10 1.7-4.3L22 16Z" />
                </svg>
            </div>

            <div class="grow">
                <div class="flex items-center gap-x-2">
                    <p class="text-xs tracking-wide text-gray-500 uppercase">
                        Order Status
                    </p>
                </div>
                <div class="flex items-center mt-1 gap-x-2">
                    @php
                    $status = '';
                    if ($order->status->value == 'new') {
                    $status = '<span class="px-3 py-1 text-white bg-blue-500 rounded shadow">New</span>';
                    }
                    if ($order->status->value == 'processing') {
                    $status = '<span class="px-3 py-1 text-white bg-orange-500 rounded shadow">Processing</span>';
                    }
                    if ($order->status->value == 'shipped') {
                    $status = '<span class="px-3 py-1 text-white bg-teal-500 rounded shadow">Shipped</span>';
                    }
                    if ($order->status->value == 'delivered') {
                    $status = '<span class="px-3 py-1 text-white bg-green-500 rounded shadow">Delivered</span>';
                    }
                    if ($order->status->value == 'cancelled') {
                    $status = '<span class="px-3 py-1 text-white bg-red-500 rounded shadow">Cancelled</span>';
                    }
                    @endphp
                    {!! $status !!}
                </div>
            </div>
        </div>
    </div>
    <!-- End Card -->

    <!-- Card -->
    <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-slate-900 dark:border-gray-800">
        <div class="flex p-4 md:p-5 gap-x-4">
            <div
                class="flex-shrink-0 flex justify-center items-center size-[46px] bg-gray-100 rounded-lg dark:bg-gray-800">
                <svg class="flex-shrink-0 text-gray-600 size-5 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M5 12s2.545-5 7-5c4.454 0 7 5 7 5s-2.546 5-7 5c-4.455 0-7-5-7-5z" />
                    <path d="M12 13a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
                    <path d="M21 17v2a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-2" />
                    <path d="M21 7V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2" />
                </svg>
            </div>

            <div class="grow">
                <div class="flex items-center gap-x-2">
                    <p class="text-xs tracking-wide text-gray-500 uppercase">
                        Payment Status
                    </p>
                </div>
                <div class="flex items-center mt-1 gap-x-2">
                    @php
                    $paymentStatusBadge = match($order->payment_status) {
                    'paid' => '<span class="px-3 py-1 text-white bg-green-500 rounded shadow">Paid</span>',
                    'pending' => '<span class="px-3 py-1 text-white rounded shadow bg-amber-500">Pending</span>',
                    'failed' => '<span class="px-3 py-1 text-white bg-red-500 rounded shadow">Failed</span>',
                    default => '<span class="px-3 py-1 text-white bg-gray-500 rounded shadow">Unknown</span>'
                    };
                    @endphp
                    {!! $paymentStatusBadge !!}
                </div>
            </div>
        </div>
    </div>
    <!-- End Card -->
</div>
<!-- End Grid -->

<div class="flex flex-col gap-4 mt-4 md:flex-row">
    <div class="md:w-3/4">
        <div class="p-6 mb-4 overflow-x-auto bg-white rounded-lg shadow-md">
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="font-semibold text-left">Product</th>
                        <th class="font-semibold text-left">Price</th>
                        <th class="font-semibold text-left">Quantity</th>
                        <th class="font-semibold text-left">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order_items as $item)
                    <tr wire:key="{{ $item->id }}">
                        <td class="py-4">
                            <div class="flex items-center">
                                <img class="w-16 h-16 mr-4"
                                    src="{{ $item->product->getFirstMediaUrl('product-images') }}" alt="Product image">
                                <span class="font-semibold">{{ $item->product->name }}</span>
                            </div>
                        </td>
                        <td class="py-4">PHP {{ number_format($item->unit_price, 2) }}</td>
                        <td class="py-4">
                            <span class="w-8 text-center">{{ $item->qty }}</span>
                        </td>
                        <td class="py-4">PHP {{ number_format($item->unit_price * $item->qty, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="p-6 mb-4 overflow-x-auto bg-white rounded-lg shadow-md">
            <h1 class="mb-3 font-bold font-3xl text-slate-500">Shipping Address</h1>
            @if($address)
            <div class="flex items-center justify-between">
                <div>
                    <p>{{ $address->street_address }}, {{ $address->city }}, {{ $address->state }}, {{
                        $address->zip_code }}</p>
                </div>
                <div>
                    <p class="font-semibold">Phone:</p>
                    <p>{{ $address->phone }}</p>
                </div>
            </div>
            @else
            <p>No shipping address available.</p>
            @endif
        </div>

        <!-- Action Buttons -->
        <div class="flex mt-6 space-x-4">
            @if (!in_array($order->status->value, ['delivered', 'cancelled', 'processing', 'new']))
            <button wire:click="confirmDelivered"
                class="px-4 py-2 font-semibold text-white bg-green-500 rounded hover:bg-green-600">
                Confirm Delivered
            </button>
            @endif
            @if (!in_array($order->status->value, ['delivered', 'cancelled', 'shipped', 'processing']))
            <button wire:click="cancelOrder"
                class="px-4 py-2 font-semibold text-white bg-red-500 rounded hover:bg-red-600">
                Cancel Order
            </button>
            @endif
        </div>

    </div>
    <div class="md:w-1/4">
        <div class="p-6 bg-white rounded-lg shadow-md">
            <h2 class="mb-4 text-lg font-semibold">Summary</h2>
            <div class="flex justify-between mb-2">
                <span>Subtotal</span>
                <span>PHP {{ number_format($order->total_price, 2) }}</span>
            </div>
            <div class="flex justify-between mb-2">
                <span>Taxes</span>
                <span>PHP 0.00</span>
            </div>
            <div class="flex justify-between mb-2">
                <span>Shipping</span>
                <span>PHP 0.00</span>
            </div>
            <hr class="my-2">
            <div class="flex justify-between mb-2">
                <span class="font-semibold">Grand Total</span>
                <span class="font-semibold">PHP {{ number_format($order->total_price, 2) }}</span>
            </div>

        </div>
    </div>
</div>
</div>
