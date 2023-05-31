<div class="bg-white px-4 py-5 sm:p-6">
    <div class="md:grid md:grid-cols-3 md:gap-6">
        <div class="md:col-span-1">
            <h3 class="text-base font-semibold leading-6 text-gray-900">General Information</h3>
        </div>
        <div class="mt-5 space-y-6 md:col-span-2 md:mt-0">
            <form wire:submit.prevent="update" class="mb-20 space-y-6">
                <div>
                    <x-input-label for="name" :value="__('Dealership Name')"/>
                    <x-text-input wire:model.defer="name" id="name" class="block mt-1 w-full" type="text" name="name"
                                  :value="old('name')"
                                  required autofocus/>
                    <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                </div>
                <div>
                    <x-input-label for="address" :value="__('Address')"/>
                    <x-text-input wire:model.defer="address" id="address" class="block mt-1 w-full" type="text"
                                  address="address"
                                  :value="old('address')"
                                  required autofocus/>
                    <x-input-error :messages="$errors->get('address')" class="mt-2"/>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <x-input-label for="city" :value="__('City')"/>
                        <x-text-input wire:model.defer="city" id="city" class="block mt-1 w-full" type="text"
                                      :value="old('city')"
                                      required autofocus/>
                        <x-input-error :messages="$errors->get('city')" class="mt-2"/>
                    </div>
                    <div>
                        <x-input-label for="state" :value="__('State')"/>
                        <x-text-input wire:model.defer="state" id="state" class="block mt-1 w-full" type="text"
                                      :value="old('state')"
                                      required autofocus/>
                        <x-input-error :messages="$errors->get('state')" class="mt-2"/>
                    </div>
                    <div>
                        <x-input-label for="postal_code" :value="__('Zip Code')"/>
                        <x-text-input wire:model.defer="postal_code" id="postal_code" class="block mt-1 w-full"
                                      type="text"
                                      :value="old('postal_code')"
                                      required autofocus/>
                        <x-input-error :messages="$errors->get('postal_code')" class="mt-2"/>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="phone" :value="__('Phone Number')"/>
                        <x-text-input wire:model.defer="phone" id="phone" class="block mt-1 w-full" type="text"
                                      :value="old('phone')"
                                      required autofocus/>
                        <x-input-error :messages="$errors->get('phone')" class="mt-2"/>
                    </div>
                    <div>
                        <x-input-label for="website" :value="__('Website URL')"/>
                        <x-text-input wire:model.defer="website" id="website" class="block mt-1 w-full" type="text"
                                      :value="old('website')"
                                      required autofocus/>
                        <x-input-error :messages="$errors->get('website')" class="mt-2"/>
                    </div>
                </div>
                <div>
                    <div class="space-y-6 border border-gray-300 shadow-sm rounded-lg p-3">
                        <div>
                            @if($logo)
                                <img src="{{ asset($logo) }}" alt="logo" class="h-24 w-full object-contain">
                            @endif
                        </div>
                        <div>
                            <x-text-input
                                wire:model.defer="logo"
                                id="logo"
                                name="logo"
                                class="sr-only"
                                type="file"
                            />
                            <label for="logo">
                                    <span
                                        class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 hover:cursor-pointer">
                                        Upload Logo
                                    </span>
                            </label>
                            <div wire:loading.delay wire:target="logo">Uploading...</div>
                            <p class="mt-2 text-xs leading-5 text-gray-400">JPG or PNG. 1MB max.</p>
                        </div>
                        @error('logo') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="py-3 text-right">
                    <x-primary-button>Update</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</div>
