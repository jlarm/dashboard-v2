<x-wire-elements-pro::tailwind.slide-over on-submit="save" :content-padding="true">
    <x-slot name="title">Your Title</x-slot>

    <div>
        <label>Your email</label>
        <input type="email" placeholder="demo@wire-elements.dev">
    </div>

    <x-slot name="buttons">
        <button type="submit">
            Save Changes
        </button>
        <button type="button" wire:click="$emit('slide-over.close')">
            Cancel
        </button>
    </x-slot>
</x-wire-elements-pro::tailwind.slide-over>
