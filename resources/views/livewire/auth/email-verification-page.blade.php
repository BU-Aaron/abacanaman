    <div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-md">
                <!-- Title and Message -->
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                        Verify Your Email
                    </h2>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        Please verify your email address to enable purchasing functionality. You can still browse products and explore the marketplace while unverified.
                    </p>
                </div>

                @if (session()->has('message'))
                    <div class="bg-green-100 border text-center border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                        {{ session('message') }}
                    </div>
                @endif

                <!-- Actions -->
                <div class="space-y-4">
                    <button
                        wire:click="resend"
                        wire:loading.attr="disabled"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 disabled:opacity-50"
                    >
                        <span wire:loading>Resend Verification Email</span>
                    </button>

                    <button
                        wire:click="logout"
                        class="w-full flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-600"
                    >
                        Logout
                    </button>
                </div>
            </div>
        </div>
    </div>
