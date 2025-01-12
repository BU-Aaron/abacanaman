<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Mail\OrderPlaced;
use App\Models\Shop\Order;
use App\Models\Shop\OrderAddress;
use App\Models\Shop\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Checkout')]
class CheckoutPage extends Component
{
    use WithFileUploads;

    public $first_name;
    public $last_name;
    public $phone;
    public $street_address;
    public $city;
    public $state;
    public $zip_code;
    public $payment_method = 'cod';

    public $gcash_reference;
    public $gcash_receipt;

    public function mount()
    {
        $user = Auth::user();

        if ($user) {
            // Split the user's name into first and last names
            $nameParts = explode(' ', $user->name, 2);
            $this->first_name = $nameParts[0] ?? '';
            $this->last_name = $nameParts[1] ?? '';

            $this->phone = $user->phone_number;
            $this->street_address = $user->address;
            $this->city = $user->city;
            $this->state = $user->state;
            $this->zip_code = $user->zip_code;
        }

        $cart_items = CartManagement::getCartItemsFromCookie();
        // You can also initialize other properties if needed
    }

    public function placeOrder()
    {
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'street_address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip_code' => 'required',
            'payment_method' => 'required',
        ];

        if ($this->payment_method === 'gcash') {
            $rules['gcash_reference'] = 'required|string|max:255';
            $rules['gcash_receipt'] = 'required|image|max:2048';
        }

        $this->validate($rules);

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

        $order = Order::create([
            'number' => $orderNumber,
            'user_id' => Auth::id(),
            'currency' => 'php',
            'payment_method' => $this->payment_method,
            'payment_status' => $this->payment_method === 'gcash' ? 'paid' : 'pending',
            'total_price' => CartManagement::calculateGrandTotal($cart_items),
            'status' => 'new',
            'shipping_method' => 'pickup',
            'shipping_price' => 0,
            'notes' => 'Order created by ' . Auth::user()->name,
        ]);

        $orderAddress = new OrderAddress([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'street_address' => $this->street_address,
            'city' => $this->city,
            'state' => $this->state,
            'zip_code' => $this->zip_code,
        ]);

        $order->address()->save($orderAddress);

        foreach ($cart_items as $item) {
            $order->items()->create([
                'shop_product_id' => $item['product_id'],
                'qty' => $item['quantity'],
                'unit_price' => $item['unit_amount'],
            ]);
        }

        if ($this->payment_method === 'gcash') {
            $receiptPath = $this->gcash_receipt->store('gcash_receipts', 'public');

            Payment::create([
                'order_id' => $order->id,
                'reference' => $this->gcash_reference,
                'provider' => 'gcash',
                'method' => 'manual',
                'amount' => $order->total_price,
                'currency' => 'php',
                'receipt_image' => $receiptPath,
            ]);

            $redirect_url = route('success');
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
