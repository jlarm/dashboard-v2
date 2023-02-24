<x-wire-elements-pro::tailwind.slide-over on-submit="updateDealership" :content-padding="true">
    <x-slot name="title">{{ $dealership->name }}</x-slot>

    <div class="space-y-10">
        <!-- Dealership Name -->
        <div>
            <x-input-label for="name" :value="__('Dealership Name')"/>
            <x-text-input wire:model.defer="name" id="name" class="block mt-1 w-full" type="text" name="name"
                          :value="old('name')" placeholder="ABC Ford" required/>
            <x-input-error :messages="$errors->get('name')" class="mt-2"/>
        </div>

        <!-- Dealership Address -->
        <div>
            <x-input-label for="address" :value="__('Dealership Address')"/>
            <x-text-input wire:model.defer="address" id="address" class="block mt-1 w-full" type="text" name="address"
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
                              :value="old('fax')"/>
                <x-input-error :messages="$errors->get('fax')" class="mt-2"/>
            </div>
        </div>

        <!-- Dealership Website URL -->
        <div>
            <x-input-label for="url" :value="__('Dealership Website URL')"/>
            <x-text-input wire:model.defer="url" id="url" class="block mt-1 w-full" type="url" name="url"
                          :value="old('url')" placeholder="https://abcford.com" required/>
            <x-input-error :messages="$errors->get('url')" class="mt-2"/>
        </div>

        <!-- Consultant -->
        <div>
            <label for="user" class="block text-sm font-medium text-gray-700">Consultant</label>
            <select wire:model.defer="user" id="user" name="user"
                    class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Multiple Locations -->
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

        <x-slot name="buttons">
            <div class="space-x-5">
                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-md border border-transparent bg-arm-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-arm-blue-700 focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2 sm:w-auto"
                >
                    Save Changes
                </button>
                <button
                    type="button"
                    wire:click="$emit('slide-over.close')"
                    class="inline-flex items-center justify-center rounded-md border border-arm-blue-600 px-4 py-2 text-sm font-medium text-arm-blue-600 shadow-sm focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2 sm:w-auto"
                >
                    Cancel
                </button>
            </div>
        </x-slot>

    </div>

</x-wire-elements-pro::tailwind.slide-over>
