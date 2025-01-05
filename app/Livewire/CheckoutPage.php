<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Mail\OrderPlaced;
use App\Models\Shop\Order;
use App\Models\Shop\OrderAddress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Title;
use Livewire\Component;
use Stripe\Checkout\Session;
use Stripe\Stripe;

#[Title('Checkout')]
class CheckoutPage extends Component
{
    public $first_name;
    public $last_name;
    public $phone;
    public $street_address;
    public $city;
    public $state;
    public $zip_code;
    public $payment_method;

    public function placeOrder()
    {
        $this->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'street_address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip_code' => 'required',
            'payment_method' => 'required',
        ]);

        $cart_items = CartManagement::getCartItemsFromCookie();

        $line_items = [];

        foreach ($cart_items as $item) {
            $line_items[] = [
                'price_data' => [
                    'currency' => 'php',
                    'unit_amount' => $item['unit_amount'] * 100,
                    'product_data' => [
                        'name' => $item['product_name'],
                    ],
                ],
                'quantity' => $item['quantity'],
            ];
        }

        $redirect_url = '';

        $orderNumber = 'OR-' . strtoupper(uniqid());

        // Create the Order
        $order = Order::create([
            'number' => $orderNumber,
            'user_id' => Auth::id(),
            'currency' => 'php',
            'total_price' => CartManagement::calculateGrandTotal($cart_items),
            'status' => 'new',
            'shipping_method' => 'pickup',
            'shipping_price' => 0,
            'notes' => 'Order created by ' . Auth::user()->name,
        ]);

        // Create the Order Address
        $orderAddress = new OrderAddress([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'street_address' => $this->street_address,
            'city' => $this->city,
            'state' => $this->state,
            'zip_code' => $this->zip_code,
        ]);

        // Associate the address with the order
        $order->address()->save($orderAddress);

        // Create Order Items
        foreach ($cart_items as $item) {
            $order->items()->create([
                'shop_product_id' => $item['product_id'],
                'qty' => $item['quantity'],
                'unit_price' => $item['unit_amount'],
            ]);
        }

        if ($this->payment_method === 'stripe') {
            Stripe::setApikey(env('STRIPE_SECRET'));
            $sessionCheckout = Session::create([
                'payment_method_types' => ['card'],
                'customer_email' => Auth::user()->email,
                'line_items' => $line_items,
                'mode' => 'payment',
                'success_url' => route('success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('cancelled'),
            ]);

            $redirect_url = $sessionCheckout->url;
        } else {
            $redirect_url = route('success');
        }

        CartManagement::clearCartItems();
        Mail::to(request()->user())->send(new OrderPlaced($order));
        return redirect($redirect_url);
    }

    public function render()
    {
        $cart_items = CartManagement::getCartItemsFromCookie();
        $grand_total = CartManagement::calculateGrandTotal($cart_items);
        return view('livewire.checkout-page', compact('cart_items', 'grand_total'));
    }
}
