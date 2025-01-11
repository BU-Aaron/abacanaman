<div class="flex items-start justify-center min-h-screen mt-6">
    <!-- Sidebar: Seller Info -->
    <div class="w-full max-w-sm bg-white dark:bg-gray-800 p-6 rounded-lg mr-4 flex flex-col items-center">
        @if($seller->store_logo)
            <img src="{{ $seller->store_logo }}" alt="{{ $seller->store_name }}" class="w-32 h-32 mb-4 rounded-full object-cover">
        @else
            <img src="https://placehold.co/600x400" alt="{{ $seller->store_name }}" class="w-32 h-32 mb-4 rounded-full object-cover">
        @endif
        <h2 class="text-2xl font-bold dark:text-gray-200">{{ $seller->user->name }}</h2>
        <p class="text-gray-600 dark:text-gray-400 mt-2">{{ $seller->store_description }}</p>
    </div>

    <!-- Chat Area -->
    <div class="flex flex-col w-full max-w-3xl h-[85vh] bg-white dark:bg-gray-800 rounded-lg">
        <!-- Messages Area -->
        <div class="flex-1 p-6 overflow-y-auto" style="scroll-behavior: smooth;">
            @foreach($messages as $message)
                <div class="flex mb-4 {{ $message['sender_id'] === auth()->id() ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-md px-4 py-2 rounded-lg
                        {{ $message['sender_id'] === auth()->id() ? 'bg-blue-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200' }}">
                        <p class="text-sm">{{ $message['content'] }}</p>
                        <span class="block text-xs mt-1 text-right">{{ \Carbon\Carbon::parse($message['created_at'])->diffForHumans() }}</span>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Input Area -->
        <div class="p-4 bg-gray-100 dark:bg-gray-700">
            <form wire:submit.prevent="sendMessage" class="flex">
                <input type="text" wire:model="newMessage" placeholder="Type your message..."
                    class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-600 dark:text-white" />
                <button type="submit"
                    class="px-6 py-2 bg-blue-500 text-white rounded-r-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Send
                </button>
            </form>
        </div>
    </div>
</div>
