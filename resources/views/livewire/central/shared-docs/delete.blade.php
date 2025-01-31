<x-wire-elements-pro::tailwind.modal on-submit="delete">
    <x-slot name="title">Delete Document</x-slot>

    <div>
        Are you sure you want to delete the {{ $sharedDocument->title }} document?
    </div>

    <x-slot name="buttons">
        <x-danger-button type="submit">Delete</x-danger-button>
        <x-secondary-button type="button" wire:click="$emit('modal.close')">Cancel</x-secondary-button>
    </x-slot>
</x-wire-elements-pro::tailwind.modal>
