<x-wire-elements-pro::tailwind.modal on-submit="updateStore" :content-padding="true">
    <x-slot name="title">Edit Location</x-slot>

    <div class="space-y-5">
        <div>
            <label for="location_name" class="block text-sm font-medium text-gray-700">Name</label>
            <div class="mt-1">
                <input
                    wire:model.defer="name"
                    id="location_name"
                    type="text"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"
                >
                @error('name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label for="location_address" class="block text-sm font-medium text-gray-700">Address</label>
            <div class="mt-1">
                <input
                    wire:model.defer="address"
                    id="location_address"
                    type="text"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"
                >
                @error('address')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div>
                <label for="location_city" class="block text-sm font-medium text-gray-700">City</label>
                <div class="mt-1">
                    <input
                        wire:model.defer="city"
                        id="location_city"
                        type="text"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"
                    >
                    @error('city')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="location_state" class="block text-sm font-medium text-gray-700">State</label>
                <div class="mt-1">
                    <input
                        wire:model.defer="state"
                        id="location_state"
                        type="text"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"
                    >
                    @error('state')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="location_postal_code" class="block text-sm font-medium text-gray-700">Postal Code</label>
                <div class="mt-1">
                    <input
                        wire:model.defer="postal_code"
                        id="location_postal_code"
                        type="text"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"
                    >
                    @error('postal_code')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
                <label for="location_phone" class="block text-sm font-medium text-gray-700">Phone</label>
                <div class="mt-1">
                    <input
                        wire:model.defer="phone"
                        id="location_phone"
                        type="text"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"
                    >
                    @error('phone')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="location_website" class="block text-sm font-medium text-gray-700">Website</label>
                <div class="mt-1">
                    <input
                        wire:model.defer="website"
                        id="location_website"
                        type="url"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"
                    >
                    @error('website')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <x-slot name="buttons">
        <x-armp.button type="submit" variant="primary">Create</x-armp.button>
        <x-armp.button type="button" wire:click="$emit('modal.close')" variant="outline">Cancel</x-armp.button>
    </x-slot>
</x-wire-elements-pro::tailwind.modal>
