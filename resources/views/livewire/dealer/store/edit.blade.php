<x-wire-elements-pro::tailwind.slide-over on-submit="updateStore">
    <x-slot name="title">Edit</x-slot>

    <div class="space-y-5">
        <div>
            <label
                for="name"
                class="block text-sm font-medium text-gray-700"
            >
                Dealership Name
            </label>
            <div class="mt-1">
                <input
                    wire:model.defer="name"
                    type="text"
                    name="name"
                    id="name"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"
                >
            </div>
        </div>
        <div>
            <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
            <div class="mt-1">
                <input
                    wire:model.defer="address"
                    type="text"
                    name="address"
                    id="address"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"
                >
            </div>
        </div>
        <div class="grid grid-cols-1 gap-y-10 gap-x-4 sm:grid-cols-6">
            <div class="sm:col-span-2">
                <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                <div class="mt-1">
                    <input
                        wire:model.defer="city"
                        type="text"
                        name="city"
                        id="city"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"
                    >
                </div>
            </div>
            <div class="sm:col-span-2">
                <label for="state" class="block text-sm font-medium text-gray-700">State</label>
                <div class="mt-1">
                    <input
                        wire:model.defer="state"
                        type="text"
                        name="state"
                        id="state"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"
                    >
                </div>
            </div>
            <div class="sm:col-span-2">
                <label for="postal_code" class="block text-sm font-medium text-gray-700">Postal Code</label>
                <div class="mt-1">
                    <input
                        wire:model.defer="postal_code"
                        type="text"
                        name="postal_code"
                        id="postal_code"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"
                    >
                </div>
            </div>
            <div class="sm:col-span-3">
                <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                <div class="mt-1">
                    <input
                        wire:model.defer="phone"
                        x-mask="999-999-9999"
                        type="text"
                        name="phone"
                        id="phone"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"
                        placeholder="235-456-2346"
                    >
                </div>
            </div>
            <div class="sm:col-span-3">
                <label for="website" class="block text-sm font-medium text-gray-700">Website URL</label>
                <div class="mt-1">
                    <input
                        wire:model.defer="website"
                        type="url"
                        name="website"
                        id="website"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"
                        placeholder="https://google.com"
                    >
                </div>
            </div>
        </div>
    </div>

    <x-slot name="buttons">
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
    </x-slot>
