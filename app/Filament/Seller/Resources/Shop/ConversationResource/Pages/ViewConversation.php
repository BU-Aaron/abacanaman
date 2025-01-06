<?php

namespace App\Filament\Seller\Resources\Shop\ConversationResource\Pages;

use App\Filament\Seller\Resources\Shop\ConversationResource;
use App\Models\Shop\Message;
use Filament\Forms;
use Filament\Resources\Pages\ViewRecord;
use Filament\Tables;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ViewConversation extends ViewRecord
{
    protected static string $resource = ConversationResource::class;

    // Property to hold the new message content
    public $newMessage;

    protected function getHeaderActions(): array
    {
        return [
            // Add any header actions if needed
        ];
    }

    protected function getFormSchema(): array
    {
        return [
            // Since we're focusing on chat, the form schema can be minimal or omitted
        ];
    }

    protected function getTableQuery()
    {
        // Fetch messages related to the conversation
        return $this->record->messages()->with('sender')->latest();
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('sender.name')
                ->label('Sender')
                ->sortable(),

            Tables\Columns\TextColumn::make('content')
                ->label('Message')
                ->sortable(),

            Tables\Columns\TextColumn::make('created_at')
                ->label('Sent At')
                ->dateTime('M d, Y h:i A')
                ->sortable(),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            // Define any row actions if necessary
        ];
    }

    // Method to send a new message
    public function sendMessage()
    {
        $this->validate([
            'newMessage' => 'required|string|max:1000',
        ]);

        // Create the new message
        $message = $this->record->messages()->create([
            'sender_id' => Auth::id(),
            'content' => $this->newMessage,
        ]);

        // Optionally, emit an event or refresh the table
        // $this->emit('messageSent');

        // Clear the input field
        $this->newMessage = '';
    }

    public function render(): View
    {
        return view('filament.seller.pages.view-conversation', [
            'messages' => $this->getTableQuery()->get(),
        ]);
    }
}
