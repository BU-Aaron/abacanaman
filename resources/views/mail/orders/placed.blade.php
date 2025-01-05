<x-mail::message>
# Order Placed Successfully

Your order has been placed successfully. Your order number is {{ $order->id }}.

<x-mail::button :url="$url">
View Order
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
