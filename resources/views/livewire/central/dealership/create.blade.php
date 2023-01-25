<x-wire-elements-pro::tailwind.modal on-submit="createDealer" :content-padding="true">
    <x-slot name="title">Create Dealership</x-slot>

    <div class="space-y-5">
        <!-- Dealership Name -->
        <div>
            <x-input-label for="name" :value="__('Dealership Name')" />
            <x-text-input wire:model.defer="name" id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" placeholder="ABC Ford" required />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Dealership Domain -->
        <div>
            <x-input-label for="domain" :value="__('Dealership Domain')" />
            <div class="flex items-center">
                <x-text-input wire:model.defer="domain" id="domain" class="block mt-1 w-full" type="text" name="domain" :value="old('domain')" placeholder="abc-ford" required />
                <span>.dashboard.test</span>
            </div>
            <x-input-error :messages="$errors->get('domain')" class="mt-2" />
        </div>

        <!-- Dealership Website URL -->
        <div>
            <x-input-label for="url" :value="__('Dealership Website URL')" />
            <x-text-input wire:model.defer="url" id="url" class="block mt-1 w-full" type="url" name="url" :value="old('url')" placeholder="https://abcford.com" required />
            <x-input-error :messages="$errors->get('url')" class="mt-2" />
        </div>

        <div>
            <x-input-label class="sr-only" for="locations" :value="__('Multiple Locations')" />
            <div class="relative flex items-start">
                <div class="flex h-5 items-center">
                    <input wire:model.defer="locations" id="locations" aria-describedby="locations" name="locations" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-500">
                </div>
                <div class="ml-3 text-sm">
                    <span id="comments-description">This dealership has multiple stores.</span>
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
