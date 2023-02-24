<x-wire-elements-pro::tailwind.modal on-submit="createDealer" :content-padding="true">
    <x-slot name="title">Create Dealership</x-slot>

    <div class="space-y-5">
        <!-- Dealership Name -->
        <div>
            <x-input-label for="name" :value="__('Name')"/>
            <x-text-input wire:model.lazy="name" id="name" class="block mt-1 w-full" type="text" name="name"
                          :value="old('name')" placeholder="ABC Ford" required/>
            <x-input-error :messages="$errors->get('name')" class="mt-2"/>
        </div>

        <!-- Dealership Address -->
        <div>
            <x-input-label for="address" :value="__('Address')"/>
            <x-text-input wire:model.lazy="address" id="address" class="block mt-1 w-full" type="text" name="address"
                          :value="old('address')" required/>
            <x-input-error :messages="$errors->get('address')" class="mt-2"/>
        </div>

        <!-- Dealership City, State, Zip -->
        <div class="grid grid-cols-3 gap-5">
            <div>
                <x-input-label for="city" :value="__('City')"/>
                <x-text-input wire:model.lazy="city" id="city" class="block mt-1 w-full" type="text"
                              name="city"
                              :value="old('city')" required/>
                <x-input-error :messages="$errors->get('city')" class="mt-2"/>
            </div>
            <div>
                <x-input-label for="state" :value="__('State')"/>
                <x-text-input wire:model.lazy="state" id="state" class="block mt-1 w-full" type="text"
                              name="state"
                              :value="old('state')" required/>
                <x-input-error :messages="$errors->get('state')" class="mt-2"/>
            </div>
            <div>
                <x-input-label for="zip_code" :value="__('Zip Code')"/>
                <x-text-input wire:model.lazy="zip_code" id="zip_code" class="block mt-1 w-full" type="text"
                              name="zip_code"
                              :value="old('zip_code')" required/>
                <x-input-error :messages="$errors->get('zip_code')" class="mt-2"/>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-5">
            <!-- Dealership Phone Number -->
            <div>
                <x-input-label for="phone" :value="__('Phone')"/>
                <x-text-input wire:model.lazy="phone" id="phone" class="block mt-1 w-full" type="tel" name="phone"
                              :value="old('phone')" placeholder="555-555-5555" required/>
                <x-input-error :messages="$errors->get('phone')" class="mt-2"/>
            </div>

            <!-- Dealership Fax -->
            <div>
                <x-input-label for="fax" :value="__('Fax')"/>
                <x-text-input wire:model.lazy="fax" id="fax" class="block mt-1 w-full" type="tel" name="fax"
                              :value="old('fax')" placeholder="555-555-5555"/>
                <x-input-error :messages="$errors->get('fax')" class="mt-2"/>
            </div>
        </div>

        <!-- Dealership Domain -->
        <div>
            <x-input-label for="domain" :value="__('Domain')"/>
            <div class="flex items-center">
                <x-text-input wire:model.defer="domain" id="domain" class="block mt-1 w-full" type="text" name="domain"
                              :value="old('domain')" placeholder="abc-ford" required/>
                <span>.dashboard.test</span>
            </div>
            <x-input-error :messages="$errors->get('domain')" class="mt-2"/>
        </div>

        <!-- Dealership Website URL -->
        <div>
            <x-input-label for="url" :value="__('Website URL')"/>
            <x-text-input wire:model.defer="url" id="url" class="block mt-1 w-full" type="url" name="url"
                          :value="old('url')" placeholder="https://abcford.com" required/>
            <x-input-error :messages="$errors->get('url')" class="mt-2"/>
        </div>

        <div>
            <x-input-label class="sr-only" for="locations" :value="__('Multiple Locations')"/>
            <div class="relative flex items-start">
                <div class="flex h-5 items-center">
                    <input wire:model.defer="locations" id="locations" aria-describedby="locations" name="locations"
                           type="checkbox"
                           class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                </div>
                <div class="ml-3 text-sm">
                    <span id="comments-description">This dealership has multiple stores.</span>
                </div>
            </div>
        </div>

        <!-- Password -->
        <div class="space-y-5">
            <div class="rounded-md bg-blue-50 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <!-- Heroicon name: mini/information-circle -->
                        <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                             fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                  d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3 flex-1 md:flex md:justify-between">
                        <p class="text-sm text-blue-700">This password will be used to log into the dealership
                            dashboard.</p>
                    </div>
                </div>
            </div>
            <div>
                <x-input-label for="password" :value="__('Password')"/>
                <div class="relative" x-data="{ input: 'password' }">
                    <input wire:model.defer="password"
                           class="flex w-full text-body-l h-12 rounded-md px-2 py-3 text-gray-800 border border-solid border-gray-300"
                           id="password" name="user[password]" type="password" x-bind:type="input">
                    <div class="absolute right-0 top-0 mr-2 mt-3"
                         x-on:click="input = (input === 'password') ? 'text' : 'password'">
                        <span class="body text-show-hide text-sm text-gray-600 uppercase cursor-pointer"
                              x-text="input == 'password' ? 'show' : 'hide'">show</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <x-slot name="buttons">
        <button
            type="submit"
            class="inline-flex items-center justify-center rounded-md border border-transparent bg-arm-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-arm-blue-700 focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2 sm:w-auto"
        >
            Submit
        </button>
        <button
            type="button"
            wire:click="$emit('modal.close')"
            class="inline-flex items-center justify-center rounded-md border border-arm-blue-600 px-4 py-2 text-sm font-medium text-arm-blue-600 shadow-sm focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2 sm:w-auto"
        >
            Cancel
        </button>
    </x-slot>
</x-wire-elements-pro::tailwind.modal>
