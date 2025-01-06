<x-filament-panels::page>
    <div class="flex flex-col h-full">
        <!-- Chat Messages -->
        <div class="flex-1 p-4 overflow-y-auto bg-gray-100 dark:bg-gray-800">
        @foreach($messages as $message)
            <div class="mb-4 flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                <div class="max-w-xs p-2 rounded-lg {{ $message->sender_id === auth()->id() ? 'bg-green-500 text-white' : 'bg-white dark:bg-gray-700 text-gray-800' }}">
                    <p>{{ $message->content }}</p>
                    <span class="text-xs">{{ $message->created_at->diffForHumans() }}</span>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Send Message Form -->
    <div class="p-4 bg-white dark:bg-gray-700">
        <form wire:submit.prevent="sendMessage" class="flex">
            <input type="text" wire:model="newMessage" placeholder="Type your message..." class="flex-1 px-4 py-2 border rounded-l-lg focus:outline-none" />
            <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-r-lg hover:bg-green-600">Send</button>
        </form>

        @error('newMessage')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
        </div>
    </div>
</x-filament-panels::page>
