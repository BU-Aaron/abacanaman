<div class="w-full max-w-[100rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <div class="flex items-center h-full">
        <main class="w-full max-w-2xl p-6 mx-auto">
            <div class="bg-white border border-gray-200 shadow-sm rounded-xl dark:bg-gray-800 dark:border-gray-700">
                <div class="p-4 sm:p-7">
                    <div class="text-center">
                        <h1 class="block text-2xl font-bold text-gray-800 dark:text-white">Sign up</h1>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            Already have an account?
                            <a wire:navigate
                                class="font-medium text-amber-600 decoration-2 hover:underline dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                                href="/login">
                                Sign in here
                            </a>
                        </p>
                    </div>
                    <hr class="my-5 border-slate-300">
                    <!-- Form -->
                    <form wire:submit.prevent="save">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                            <!-- Left Column: Basic Info -->
                            <div class="space-y-4">
                                <!-- Name -->
                                <div>
                                    <label for="name" class="block mb-2 text-sm dark:text-white">Name</label>
                                    <div class="relative">
                                        <input type="text" id="name" name="name" wire:model="name"
                                            class="block w-full px-4 py-3 text-sm border border-gray-200 rounded-lg focus:border-amber-500 focus:ring-amber-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600"
                                            required aria-describedby="name-error">
                                        @error('name')
                                        <div
                                            class="absolute inset-y-0 flex items-center pointer-events-none end-0 pe-3">
                                            <svg class="w-5 h-5 text-red-500" width="16" height="16" fill="currentColor"
                                                viewBox="0 0 16 16" aria-hidden="true">
                                                <path
                                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                            </svg>
                                        </div>
                                        @enderror
                                    </div>
                                    @error('name')
                                    <p class="mt-2 text-xs text-red-600" id="name-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="email" class="block mb-2 text-sm dark:text-white">Email address</label>
                                    <div class="relative">
                                        <input type="email" id="email" name="email" wire:model="email"
                                            class="block w-full px-4 py-3 text-sm border border-gray-200 rounded-lg focus:border-amber-500 focus:ring-amber-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600"
                                            required aria-describedby="email-error">
                                        @error('email')
                                        <div
                                            class="absolute inset-y-0 flex items-center pointer-events-none end-0 pe-3">
                                            <svg class="w-5 h-5 text-red-500" width="16" height="16" fill="currentColor"
                                                viewBox="0 0 16 16" aria-hidden="true">
                                                <path
                                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                            </svg>
                                        </div>
                                        @enderror
                                    </div>
                                    @error('email')
                                    <p class="mt-2 text-xs text-red-600" id="email-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Password -->
                                <div>
                                    <label for="password" class="block mb-2 text-sm dark:text-white">Password</label>
                                    <div class="relative">
                                        <input type="password" id="password" name="password" wire:model="password"
                                            class="block w-full px-4 py-3 text-sm border border-gray-200 rounded-lg focus:border-amber-500 focus:ring-amber-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600"
                                            required aria-describedby="password-error">
                                        @error('password')
                                        <div
                                            class="absolute inset-y-0 flex items-center pointer-events-none end-0 pe-3">
                                            <svg class="w-5 h-5 text-red-500" width="16" height="16" fill="currentColor"
                                                viewBox="0 0 16 16" aria-hidden="true">
                                                <path
                                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                            </svg>
                                        </div>
                                        @enderror
                                    </div>
                                    @error('password')
                                    <p class="mt-2 text-xs text-red-600" id="password-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Confirm Password -->
                                <div>
                                    <label for="password_confirmation"
                                        class="block mb-2 text-sm dark:text-white">Confirm
                                        Password</label>
                                    <div class="relative">
                                        <input type="password" id="password_confirmation" name="password_confirmation"
                                            wire:model="password_confirmation"
                                            class="block w-full px-4 py-3 text-sm border border-gray-200 rounded-lg focus:border-amber-500 focus:ring-amber-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600"
                                            required aria-describedby="password_confirmation-error">
                                        @error('password_confirmation')
                                        <div
                                            class="absolute inset-y-0 flex items-center pointer-events-none end-0 pe-3">
                                            <svg class="w-5 h-5 text-red-500" width="16" height="16" fill="currentColor"
                                                viewBox="0 0 16 16" aria-hidden="true">
                                                <path
                                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                            </svg>
                                        </div>
                                        @enderror
                                    </div>
                                    @error('password_confirmation')
                                    <p class="mt-2 text-xs text-red-600" id="password_confirmation-error">{{ $message }}
                                    </p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Right Column: Address Info -->
                            <div class="space-y-4">
                                <!-- Phone Number -->
                                <div>
                                    <label for="phone_number" class="block mb-2 text-sm dark:text-white">Phone
                                        Number</label>
                                    <div class="relative">
                                        <input type="text" id="phone_number" name="phone_number"
                                            wire:model="phone_number"
                                            class="block w-full px-4 py-3 text-sm border border-gray-200 rounded-lg focus:border-amber-500 focus:ring-amber-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600"
                                            required aria-describedby="phone_number-error">
                                        @error('phone_number')
                                        <div
                                            class="absolute inset-y-0 flex items-center pointer-events-none end-0 pe-3">
                                            <svg class="w-5 h-5 text-red-500" width="16" height="16" fill="currentColor"
                                                viewBox="0 0 16 16" aria-hidden="true">
                                                <path
                                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                            </svg>
                                        </div>
                                        @enderror
                                    </div>
                                    @error('phone_number')
                                    <p class="mt-2 text-xs text-red-600" id="phone_number-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Street Address -->
                                <div>
                                    <label for="street_address" class="block mb-2 text-sm dark:text-white">Street
                                        Address</label>
                                    <div class="relative">
                                        <input type="text" id="street_address" name="street_address"
                                            wire:model="street_address"
                                            class="block w-full px-4 py-3 text-sm border border-gray-200 rounded-lg focus:border-amber-500 focus:ring-amber-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600"
                                            required aria-describedby="address-error">
                                        @error('street_address')
                                        <div
                                            class="absolute inset-y-0 flex items-center pointer-events-none end-0 pe-3">
                                            <svg class="w-5 h-5 text-red-500" width="16" height="16" fill="currentColor"
                                                viewBox="0 0 16 16" aria-hidden="true">
                                                <path
                                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                            </svg>
                                        </div>
                                        @enderror
                                    </div>
                                    @error('street_address')
                                    <p class="mt-2 text-xs text-red-600" id="address-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- City -->
                                <div>
                                    <label for="city" class="block mb-2 text-sm dark:text-white">City</label>
                                    <div class="relative">
                                        <input type="text" id="city" name="city" wire:model="city"
                                            class="block w-full px-4 py-3 text-sm border border-gray-200 rounded-lg focus:border-amber-500 focus:ring-amber-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600"
                                            required aria-describedby="city-error">
                                        @error('city')
                                        <div
                                            class="absolute inset-y-0 flex items-center pointer-events-none end-0 pe-3">
                                            <svg class="w-5 h-5 text-red-500" width="16" height="16" fill="currentColor"
                                                viewBox="0 0 16 16" aria-hidden="true">
                                                <path
                                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                            </svg>
                                        </div>
                                        @enderror
                                    </div>
                                    @error('city')
                                    <p class="mt-2 text-xs text-red-600" id="city-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Province -->
                                <div>
                                    <label for="province" class="block mb-2 text-sm dark:text-white">Province</label>
                                    <div class="relative">
                                        <input type="text" id="province" name="province" wire:model="province"
                                            class="block w-full px-4 py-3 text-sm border border-gray-200 rounded-lg focus:border-amber-500 focus:ring-amber-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600"
                                            required aria-describedby="province-error">
                                        @error('province')
                                        <div
                                            class="absolute inset-y-0 flex items-center pointer-events-none end-0 pe-3">
                                            <svg class="w-5 h-5 text-red-500" width="16" height="16" fill="currentColor"
                                                viewBox="0 0 16 16" aria-hidden="true">
                                                <path
                                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                            </svg>
                                        </div>
                                        @enderror
                                    </div>
                                    @error('province')
                                    <p class="mt-2 text-xs text-red-600" id="province-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Zip Code -->
                                <div>
                                    <label for="zip_code" class="block mb-2 text-sm dark:text-white">ZIP Code</label>
                                    <div class="relative">
                                        <input type="text" id="zip_code" name="zip_code" wire:model="zip_code"
                                            class="block w-full px-4 py-3 text-sm border border-gray-200 rounded-lg focus:border-amber-500 focus:ring-amber-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600"
                                            required aria-describedby="zip_code-error">
                                        @error('zip_code')
                                        <div
                                            class="absolute inset-y-0 flex items-center pointer-events-none end-0 pe-3">
                                            <svg class="w-5 h-5 text-red-500" width="16" height="16" fill="currentColor"
                                                viewBox="0 0 16 16" aria-hidden="true">
                                                <path
                                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                            </svg>
                                        </div>
                                        @enderror
                                    </div>
                                    @error('zip_code')
                                    <p class="mt-2 text-xs text-red-600" id="zip_code-error">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-span-1 md:col-span-2">
                                <button type="submit"
                                    class="w-full px-4 py-3 text-white transition rounded-lg bg-amber-600 hover:bg-amber-700">Register</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>
