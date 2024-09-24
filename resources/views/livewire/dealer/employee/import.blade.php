<x-wire-elements-pro::tailwind.modal on-submit="import" :content-padding="true">

    <x-slot name="title">Import Employees</x-slot>
    <div class="space-y-5">
        <div>
            <label for="file-input" class="sr-only">Choose file</label>
            <input wire:model.defer="spreadsheet" type="file" name="file-input" id="file-input" class="block w-full border border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-arm-blue-500 focus:ring-arm-blue-500 disabled:opacity-50 disabled:pointer-events-none file:bg-gray-50 file:border-0 file:me-4 file:py-3 file:px-4">
            <p class="mt-1 text-sm text-gray-400">Must be a .json file</p>
            @error('spreadsheet') <p class="text-red-500">{{ $message }}</p> @enderror
        </div>
        @if (count($importErrors) > 0)
            <div class="alert alert-danger text-xs">
                <h4>Import Errors:</h4>
                <ul>
                    @foreach ($importErrors as $error)
                        <li class="mt-2 bg-red-100 border border-red-200 text-red-800 rounded-lg p-4">
                            {{ is_array($error['errors']) ? implode(', ', $error['errors']) : $error['errors'] }}<br />
                            {{ is_array($error['values']) ? json_encode($error['values']) : $error['values'] }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
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
        <x-loading-icon wire:loading />
    </x-slot>
</x-wire-elements-pro::tailwind.modal>
