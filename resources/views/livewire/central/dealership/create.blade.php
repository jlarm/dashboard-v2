<x-wire-elements-pro::tailwind.modal on-submit="createDealership" :content-padding="true">
    <x-slot name="title">Add Dealership</x-slot>

    <div class="space-y-4">
        <p class="text-sm text-gray-600">
            Enter the dealership name if this tenant has one store. If it has multiple stores, enter the group name.
        </p>

        <div>
            <x-input-label for="create_dealership_name" :value="__('Name')"/>
            <x-text-input
                wire:model.defer="name"
                id="create_dealership_name"
                class="block mt-1 w-full"
                type="text"
                name="name"
                placeholder="Brilliance Auto Group"
                required
            />
            <x-input-error :messages="$errors->get('name')" class="mt-2"/>
        </div>
    </div>

    <x-slot name="buttons">
        <x-primary-button type="submit" wire:loading.attr="disabled" wire:target="createDealership" class="inline-flex items-center gap-2">
            <svg
                wire:loading
                wire:target="createDealership"
                class="h-4 w-4 animate-spin"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
            >
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0 1 8-8v4a4 4 0 0 0-4 4H4z"/>
            </svg>
            <span wire:loading.remove wire:target="createDealership">Create</span>
            <span wire:loading wire:target="createDealership">Creating...</span>
        </x-primary-button>
        <x-secondary-button type="button" wire:click="$emit('modal.close')">Cancel</x-secondary-button>
    </x-slot>
</x-wire-elements-pro::tailwind.modal>
