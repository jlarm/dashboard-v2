<x-wire-elements-pro::tailwind.modal on-submit="markComplete">
    <x-slot name="title">Complete Deal Jacket Group</x-slot>

    <div>
        Are you sure you want to complete this quarterly audit?
    </div>

    <x-slot name="buttons">
        <x-primary-button type="submit">Complete</x-primary-button>
        <x-secondary-button type="button" wire:click="$emit('modal.close')">Cancel</x-secondary-button>
    </x-slot>
</x-wire-elements-pro::tailwind.modal>
