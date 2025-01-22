<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <h1 class="text-4xl font-bold text-slate-500">My Orders</h1>
    <div class="flex flex-col p-5 mt-4 bg-white rounded shadow-lg">
        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div class="overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-start">Order</th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-start">Date</th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-start">Order
                                    Status</th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-start">Payment
                                    Status</th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-start">Order
                                    Amount</th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-end">
                                    Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                            @php
                            $status = '';
                            if ($order->status->value == 'new') {
                            $status = '<span class="px-3 py-1 text-white bg-blue-500 rounded shadow">New</span>';
                            }
                            if ($order->status->value == 'processing') {
                            $status = '<span
                                class="px-3 py-1 text-white bg-orange-500 rounded shadow">Processing</span>';
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
                            <tr wire:key="{{ $order->id }}"
                                class="odd:bg-white even:bg-gray-100 dark:odd:bg-slate-900 dark:even:bg-slate-800">
                                <td
                                    class="px-6 py-4 text-sm font-medium text-gray-800 whitespace-nowrap dark:text-gray-200">
                                    {{ $order->number }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800 whitespace-nowrap dark:text-gray-200">{{
                                    $order->created_at->format('d-m-Y') }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800 whitespace-nowrap dark:text-gray-200">
                                    {!! $status !!}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-800 whitespace-nowrap dark:text-gray-200">
                                    @php
                                    $paymentStatus = '';
                                    if ($order->payment_status === 'paid') {
                                    $paymentStatus = '<span
                                        class="px-3 py-1 text-white bg-green-500 rounded shadow">Paid</span>';
                                    } elseif ($order->payment_status === 'pending') {
                                    $paymentStatus = '<span
                                        class="px-3 py-1 text-white rounded shadow bg-amber-500">Pending</span>';
                                    } else {
                                    $paymentStatus = '<span
                                        class="px-3 py-1 text-white bg-red-500 rounded shadow">Failed</span>';
                                    }
                                    @endphp
                                    {!! $paymentStatus !!}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-800 whitespace-nowrap dark:text-gray-200">PHP {{
                                    number_format($order->total_price, 2) }}</td>
                                <td class="px-6 py-4 text-sm font-medium whitespace-nowrap text-end">
                                    <a href="{{ route('my-orders.show', $order->id) }}"
                                        class="px-4 py-2 text-white rounded-md bg-slate-600 hover:bg-slate-500">View
                                        Details</a>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
            {{ $orders->links() }}
        </div>
    </div>
</div>
