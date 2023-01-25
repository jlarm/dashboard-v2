<x-wire-elements-pro::tailwind.modal on-submit="delete" :content-padding="true">
    <x-slot name="title">Delete User</x-slot>

   Are you sure you want to delete {{ $user->name }}?

    <x-slot name="buttons">
        <button
            type="submit"
            class="inline-flex items-center justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:w-auto"
        >
            Delete
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
