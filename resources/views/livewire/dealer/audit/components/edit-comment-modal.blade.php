<x-wire-elements-pro::tailwind.modal>
    <x-slot name="title">Edit Comment</x-slot>

    <div>
        <label for="commentText" class="block text-sm font-medium text-gray-700 mb-1">Comment</label>
        <textarea
            wire:model.defer="commentText"
            id="commentText"
            rows="4"
            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"
        ></textarea>
        @error('commentText')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <x-slot name="buttons">
        <button
            type="button"
            wire:click="edit"
            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md text-sm font-medium text-white bg-arm-blue-600 hover:bg-arm-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-arm-blue-500"
        >
            Save
        </button>
        <button
            type="button"
            wire:click="$emit('modal.close')"
            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-arm-blue-500"
        >
            Cancel
        </button>
    </x-slot>
</x-wire-elements-pro::tailwind.modal>
