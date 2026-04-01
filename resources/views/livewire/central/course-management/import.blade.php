<x-wire-elements-pro::tailwind.modal on-submit="importCourses" :content-padding="true">
    <x-slot name="title">Import Courses</x-slot>

    <div class="space-y-5">
        <div>
            <label for="course-import-file" class="sr-only">Choose file</label>
            <input
                wire:model.defer="courseImportFile"
                type="file"
                name="course-import-file"
                id="course-import-file"
                accept=".json,application/json"
                class="block w-full border border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-arm-blue-500 focus:ring-arm-blue-500 disabled:opacity-50 disabled:pointer-events-none file:bg-gray-50 file:border-0 file:me-4 file:py-3 file:px-4"
            >
            <p class="mt-1 text-sm text-gray-400">Must be a .json file.</p>
            @error('courseImportFile') <p class="text-red-500">{{ $message }}</p> @enderror
        </div>
    </div>

    <x-slot name="buttons">
        <button
            type="submit"
            class="inline-flex items-center justify-center rounded-md border border-transparent bg-arm-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-arm-blue-700 focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2 sm:w-auto"
        >
            Import
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
