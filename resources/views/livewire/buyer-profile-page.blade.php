<div class="max-w-5xl mx-auto my-10 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-200">My Profile</h2>

    @if (session()->has('message'))
        <div class="mb-4 text-green-500">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="updateProfile">
        <div class="space-y-12">
            <!-- User Profile Section -->
            <div class="flex flex-col md:flex-row bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow-sm">
                <!-- Title and Description -->
                <div class="md:w-1/3 mb-4 md:mb-0 md:pr-6">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200">User Profile</h3>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">
                        Manage your account information, including your email, name, and password.
                    </p>
                </div>
                <!-- Form Inputs -->
                <div class="md:w-2/3">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-gray-700 dark:text-gray-300">Name</label>
                            <input type="text" id="name" wire:model.defer="name" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-amber-200 dark:focus:ring-gray-600">
                            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-gray-700 dark:text-gray-300">Email</label>
                            <input type="email" id="email" wire:model.defer="email" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-amber-200 dark:focus:ring-gray-600">
                            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-gray-700 dark:text-gray-300">New Password</label>
                            <input type="password" id="password" wire:model.defer="password" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-amber-200 dark:focus:ring-gray-600">
                            @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-gray-700 dark:text-gray-300">Confirm Password</label>
                            <input type="password" id="password_confirmation" wire:model.defer="password_confirmation" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-amber-200 dark:focus:ring-gray-600">
                            @error('password_confirmation') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- divider --}}
            <div class="h-px w-full bg-gray-200"></div>
            <!-- Delivery Details Section -->
            <div class="flex flex-col md:flex-row bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow-sm">
                <!-- Title and Description -->
                <div class="md:w-1/3 mb-4 md:mb-0 md:pr-6">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Delivery Details</h3>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">
                        Update your contact information and delivery address to ensure smooth transactions.
                    </p>
                </div>
                <!-- Form Inputs -->
                <div class="md:w-2/3">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Phone Number -->
                        <div class="md:col-span-2">
                            <label for="phone_number" class="block text-gray-700 dark:text-gray-300">Phone Number</label>
                            <input type="text" id="phone_number" wire:model.defer="phone_number" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-amber-200 dark:focus:ring-gray-600">
                            @error('phone_number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Address -->
                        <div class="md:col-span-2">
                            <label for="address" class="block text-gray-700 dark:text-gray-300">Address</label>
                            <input type="text" id="address" wire:model.defer="address" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-amber-200 dark:focus:ring-gray-600">
                            @error('address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- City -->
                        <div>
                            <label for="city" class="block text-gray-700 dark:text-gray-300">City</label>
                            <input type="text" id="city" wire:model.defer="city" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-amber-200 dark:focus:ring-gray-600">
                            @error('city') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- State -->
                        <div>
                            <label for="state" class="block text-gray-700 dark:text-gray-300">State</label>
                            <input type="text" id="state" wire:model.defer="state" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-amber-200 dark:focus:ring-gray-600">
                            @error('state') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Zip Code -->
                        <div class="md:col-span-2">
                            <label for="zip_code" class="block text-gray-700 dark:text-gray-300">Zip Code</label>
                            <input type="text" id="zip_code" wire:model.defer="zip_code" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-amber-200 dark:focus:ring-gray-600">
                            @error('zip_code') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="mt-6 bg-amber-500 text-white py-2 px-4 rounded-lg hover:bg-amber-600 transition-colors">
                Update Profile
            </button>
        </div>
    </form>
</div>
