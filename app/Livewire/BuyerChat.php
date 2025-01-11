<?php

namespace App\Livewire;

use App\Models\Shop\Conversation;
use App\Models\Shop\Message;
use App\Models\Shop\Seller;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class BuyerChat extends Component
{
    public $seller_id;
    public $conversation;
    public $messages = [];
    public $newMessage;
    public $seller;
    public function mount($seller_id)
    {
        $this->seller_id = $seller_id;
        $this->conversation = Conversation::firstOrCreate(
            ['buyer_id' => Auth::id(), 'seller_id' => $seller_id]
        );
        // Convert Collection to Array
        $this->messages = $this->conversation->messages()->with('sender')->get()->toArray();
        $this->seller = Seller::with('user')->findOrFail($seller_id);
    }

    public function sendMessage()
    {
        $this->validate([
            'newMessage' => 'required|string|max:1000',
        ]);

        $message = $this->conversation->messages()->create([
            'sender_id' => Auth::id(),
            'content' => $this->newMessage,
        ]);

        // Convert the new message to Array before appending
        $this->messages[] = $message->load('sender')->toArray();
        $this->newMessage = '';
    }

    public function render()
    {
        return view('livewire.buyer-chat', [
            'seller' => $this->seller,
        ]);
    }
}
