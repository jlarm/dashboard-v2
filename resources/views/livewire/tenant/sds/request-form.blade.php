<x-wire-elements-pro::tailwind.modal on-submit="send">
    <x-slot name="title">Request SDS Sheet</x-slot>

    <div class="space-y-4">
        <div>
            <x-input-label for="name">Chemical Name *</x-input-label>
            <x-text-input
                required
                type="text"
                id="name"
                wire:model.defer="name"
                placeholder="Enter the chemical or product name"
                class="block mt-1 w-full"
            />
            <x-input-error :messages="$errors->get('name')" class="mt-2"/>
        </div>

        <div>
            <x-input-label for="manufacturer">Manufacturer</x-input-label>
            <x-text-input
                type="text"
                id="manufacturer"
                wire:model.defer="manufacturer"
                placeholder="Enter manufacturer name"
                class="block mt-1 w-full"
            />
            <x-input-error :messages="$errors->get('manufacturer')" class="mt-2"/>
        </div>
    </div>

    <x-slot name="buttons">
        <x-primary-button type="submit">
            Submit Request
        </x-primary-button>
        <x-secondary-button type="button" wire:click="$emit('modal.close')">
            Cancel
        </x-secondary-button>
    </x-slot>
</x-wire-elements-pro::tailwind.modal>
