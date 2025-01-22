<?php

namespace App\Livewire;

use App\Filament\Admin\Resources\Shop\OrderResource;
use App\Filament\Seller\Resources\Shop\OrderResource as SellerOrderResource;
use App\Helpers\CartManagement;
use App\Mail\OrderPlaced;
use App\Models\Shop\Order;
use App\Models\Shop\OrderAddress;
use App\Models\Shop\Payment;
use App\Models\User;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Checkout')]
class CheckoutPage extends Component
{
    use WithFileUploads;

    public $selected_address_id;
    public $addresses;
    public $payment_method = 'cod';
    public $gcash_reference;
    public $gcash_receipt;

    public function mount()
    {
        $user = Auth::user();
        $this->addresses = $user->addresses()->get();

        // Select the first address by default if exists
        if ($this->addresses->isNotEmpty()) {
            $this->selected_address_id = $this->addresses->first()->id;
        }
    }

    public function placeOrder()
    {
        $rules = [
            'selected_address_id' => 'required|exists:addresses,id',
            'payment_method' => 'required',
        ];

        if ($this->payment_method === 'gcash') {
            $rules['gcash_reference'] = 'required|string|max:255';
            $rules['gcash_receipt'] = 'required|image|max:2048';
        }

        $this->validate($rules);

        $user = Auth::user();
        $selectedAddress = $this->addresses->find($this->selected_address_id);

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
            'user_id' => $user->id,
            'currency' => 'php',
            'payment_method' => $this->payment_method,
            'payment_status' => $this->payment_method === 'gcash' ? 'paid' : 'pending',
            'total_price' => CartManagement::calculateGrandTotal($cart_items),
            'status' => 'new',
            'shipping_method' => 'pickup',
            'shipping_price' => 0,
            'notes' => 'Order created by ' . $user->name,
        ]);

        $orderAddress = new OrderAddress([
            'first_name' => explode(' ', $user->name)[0] ?? '',
            'last_name' => explode(' ', $user->name)[1] ?? '',
            'phone' => $user->phone_number,
            'street_address' => $selectedAddress->address,
            'city' => $selectedAddress->city,
            'state' => $selectedAddress->state,
            'zip_code' => $selectedAddress->zip_code,
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

        // Collect unique sellers from the order items
        $sellers = $order->items->map(function ($item) {
            return $item->product->seller;
        })->unique('id');


        // Send notification to each seller

        foreach ($sellers as $seller) {
            $sellerUser = $seller->user;

            if ($sellerUser) {
                Notification::make()
                    ->title('New Order for your Product')
                    ->icon('heroicon-o-shopping-bag')
                    ->body("A new order (#{$order->number}) has been placed for your product(s).")
                    ->actions([
                        Action::make('View Order')
                            ->url("/seller/shop/orders/{$order->id}/edit"),
                    ])
                    ->sendToDatabase($sellerUser);
            }
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
