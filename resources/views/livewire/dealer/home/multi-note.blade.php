<form wire:submit.prevent="update" class="bg-gray-50 p-5 rounded-md text-left">
    <label for="comment" class="block text-sm font-medium leading-6 text-gray-900">Consultant Notes</label>
    <p class="text-sm text-gray-400">Add any notes you would like to refer back to. Only you as the consultant will see
        these notes.</p>
    <div class="my-2">
        <label>
            <textarea
                x-data
                x-autosize
                wire:model.defer="note"
                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"
            ></textarea>
        </label>
    </div>
    <x-primary-button>Update</x-primary-button>
</form>
