<form action="{{ route('dealerships.store') }}" method="POST" class="space-y-5 max-w-4xl mx-auto">
    @csrf
    <div class="space-y-5">
        <!-- Dealership Name -->
        <div>
            <x-input-label for="name" :value="__('Dealership Name')"/>
            <x-text-input
                wire:model.defer="name"
                id="name"
                class="block mt-1 w-full"
                type="text"
                name="name"
                :value="old('name')"
                required
            />
            <x-input-error :messages="$errors->get('name')" class="mt-2"/>
        </div>

        <!-- Dealership Address -->
        <div>
            <x-input-label for="address" :value="__('Address')"/>
            <x-text-input wire:model.defer="address" id="address" class="block mt-1 w-full"
                          type="text" name="address"
                          :value="old('address')" required/>
            <x-input-error :messages="$errors->get('address')" class="mt-2"/>
        </div>

        <!-- Dealership City, State, Zip -->
        <div class="grid grid-cols-3 gap-5">
            <div>
                <x-input-label for="city" :value="__('City')"/>
                <x-text-input wire:model.defer="city" id="city" class="block mt-1 w-full" type="text"
                              name="city"
                              :value="old('city')" required/>
                <x-input-error :messages="$errors->get('city')" class="mt-2"/>
            </div>
            <div>
                <x-input-label for="state" :value="__('State')"/>
                <x-text-input wire:model.defer="state" id="state" class="block mt-1 w-full"
                              type="text"
                              name="state"
                              :value="old('state')" required/>
                <x-input-error :messages="$errors->get('state')" class="mt-2"/>
            </div>
            <div>
                <x-input-label for="zip_code" :value="__('Zip Code')"/>
                <x-text-input wire:model.defer="zip_code" id="zip_code" class="block mt-1 w-full"
                              type="text"
                              name="zip_code"
                              :value="old('zip_code')" required/>
                <x-input-error :messages="$errors->get('zip_code')" class="mt-2"/>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-5">
            <!-- Dealership Phone Number -->
            <div>
                <x-input-label for="phone" :value="__('Phone')"/>
                <x-text-input
                    x-mask="999-999-9999"
                    placeholder="235-456-2346"
                    wire:model.defer="phone"
                    id="phone"
                    class="block mt-1 w-full"
                    type="tel" name="phone"
                    :value="old('phone')" required/>
                <x-input-error :messages="$errors->get('phone')" class="mt-2"/>
            </div>

            <!-- Dealership Fax -->
            <div>
                <x-input-label for="fax" :value="__('Fax')"/>
                <x-text-input
                    placeholder="235-456-2346"
                    wire:model.defer="fax"
                    id="fax"
                    class="block mt-1 w-full"
                    type="tel"
                    name="fax"
                    :value="old('fax')"
                />
                <x-input-error :messages="$errors->get('fax')" class="mt-2"/>
            </div>
        </div>

        <!-- Dealership Domain -->
        <div>
            <x-input-label for="domain" :value="__('Domain')"/>
            <div class="flex items-center">
                <x-text-input
                    wire:model.defer="domain"
                    id="domain"
                    class="block mt-1 w-full"
                    type="text"
                    name="domain"
                    :value="old('domain')"
                    required
                />
                <span>.{{ config('tenancy.central_domains')[0] }}</span>
            </div>
            <x-input-error :messages="$errors->get('domain')" class="mt-2"/>
        </div>

        <!-- Dealership Website URL -->
        <div>
            <x-input-label for="url" :value="__('Website URL')"/>
            <x-text-input wire:model.defer="url" id="url" class="block mt-1 w-full" type="url"
                          name="url" required/>
            <x-input-error :messages="$errors->get('url')" class="mt-2"/>
        </div>

        <div>
            <label for="locations">
                <x-input-label class="sr-only" for="locations" :value="__('Multiple Locations')"/>
                <div class="relative flex items-start">
                    <div class="flex h-5 items-center">
                        <input type="hidden" name="locations" value="0"/>
                        <input wire:model.defer="locations" id="locations"
                               aria-describedby="locations"
                               name="locations"
                               type="checkbox"
                               class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                    </div>
                    <div class="ml-3 text-sm">
                        <span id="comments-description">This dealership has multiple stores.</span>
                    </div>
                </div>
            </label>
        </div>

        <!-- Employees -->
        <div>
            <x-input-label for="locations" :value="__('Select the users that should have access')"/>
            @foreach($users as $user)
                <div class="relative flex items-start">
                    <div class="flex h-6 items-center">
                        <input
                            name="user"
                            type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                    </div>
                    <div class="ml-3 text-sm leading-6">
                        <label for="{{ $user->name }}"
                               class="text-gray-900">{{ $user->name }}</label>
                    </div>
                </div>
            @endforeach
        </div>

    </div>

    <div>
        <button
            type="submit"
            class="inline-flex items-center justify-center rounded-md border border-transparent bg-arm-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-arm-blue-700 focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2 sm:w-auto"
        >
            Submit
        </button>
    </div>
</form>
