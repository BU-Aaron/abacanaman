<div class="p-6 mx-auto max-w-7xl">
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
        <!-- Basic Profile - Left Column -->
        <div class="lg:col-span-7">
            <div class="p-6 bg-white rounded-lg shadow-md dark:bg-gray-800">
                <h2 class="mb-6 text-2xl font-semibold text-gray-800 dark:text-gray-200">My Profile</h2>

                @if (session()->has('message'))
                <div class="mb-4 text-green-600 dark:text-green-400">
                    {{ session('message') }}
                </div>
                @endif

                <form wire:submit.prevent="updateProfile">
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300" for="name">Name</label>
                        <input type="text" wire:model.defer="name" id="name"
                            class="w-full px-3 py-2 border border-gray-300 rounded dark:bg-gray-700 dark:text-gray-200">
                        @error('name') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300" for="email">Email</label>
                        <input type="email" wire:model.defer="email" id="email"
                            class="w-full px-3 py-2 border border-gray-300 rounded dark:bg-gray-700 dark:text-gray-200">
                        @error('email') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300" for="password">Password</label>
                        <input type="password" wire:model.defer="password" id="password"
                            class="w-full px-3 py-2 border border-gray-300 rounded dark:bg-gray-700 dark:text-gray-200"
                            placeholder="Leave blank to keep current password">
                        @error('password') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300" for="password_confirmation">Confirm
                            Password</label>
                        <input type="password" wire:model.defer="password_confirmation" id="password_confirmation"
                            class="w-full px-3 py-2 border border-gray-300 rounded dark:bg-gray-700 dark:text-gray-200"
                            placeholder="Leave blank to keep current password">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300" for="phone_number">Phone Number</label>
                        <input type="text" wire:model.defer="phone_number" id="phone_number"
                            class="w-full px-3 py-2 border border-gray-300 rounded dark:bg-gray-700 dark:text-gray-200">
                        @error('phone_number') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="px-4 py-2 text-white rounded bg-amber-600 hover:bg-amber-700">
                        Update Profile
                    </button>
                </form>
            </div>
        </div>

        <!-- Addresses - Right Column -->
        <div class="lg:col-span-5">
            <div class="p-6 bg-white rounded-lg shadow-md dark:bg-gray-800">
                <h3 class="mb-4 text-xl font-semibold text-gray-800 dark:text-gray-200">My Addresses</h3>

                <ul class="mb-6">
                    @foreach ($addresses as $address)
                    <li class="flex items-center justify-between p-4 mb-4 bg-gray-100 rounded dark:bg-gray-700">
                        <div>
                            <p class="text-gray-800 dark:text-gray-200">{{ $address['street'] }}</p>
                            <p class="text-gray-600 dark:text-gray-400">{{ $address['city'] }}, {{ $address['state'] }}
                                {{
                                $address['zip'] }}</p>
                        </div>
                        <button wire:click="removeAddress({{ $address['id'] }})"
                            class="text-red-500 hover:text-red-700">
                            Delete
                        </button>
                    </li>
                    @endforeach
                </ul>

                <h3 class="mb-4 text-xl font-semibold text-gray-800 dark:text-gray-200">Add New Address</h3>

                <form wire:submit.prevent="addAddress">
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300" for="newAddress.address">Street
                            Address</label>
                        <input type="text" wire:model.defer="newAddress.address" id="newAddress.address"
                            class="w-full px-3 py-2 border border-gray-300 rounded dark:bg-gray-700 dark:text-gray-200">
                        @error('newAddress.address') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300" for="newAddress.city">City</label>
                        <input type="text" wire:model.defer="newAddress.city" id="newAddress.city"
                            class="w-full px-3 py-2 border border-gray-300 rounded dark:bg-gray-700 dark:text-gray-200">
                        @error('newAddress.city') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300" for="newAddress.state">Province</label>
                        <input type="text" wire:model.defer="newAddress.state" id="newAddress.state"
                            class="w-full px-3 py-2 border border-gray-300 rounded dark:bg-gray-700 dark:text-gray-200">
                        @error('newAddress.state') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300" for="newAddress.zip_code">Zip Code</label>
                        <input type="text" wire:model.defer="newAddress.zip_code" id="newAddress.zip_code"
                            class="w-full px-3 py-2 border border-gray-300 rounded dark:bg-gray-700 dark:text-gray-200">
                        @error('newAddress.zip_code') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">
                        Add Address
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
