<div class="max-w-3xl mx-auto" x-data="{
    isDropping: false,
    isUploading: false,
    isSubmitting: false,
    progress: 0,
    handleFileDrop(event) {
        const files = event.dataTransfer.files;
        if (files.length > 0) {
            const file = files[0];
            if (file.type === 'application/pdf' && file.size <= 10485760) { // 10MB limit
                @this.upload('file', file, (uploadedFilename) => {
                    // Upload complete
                    this.isUploading = false;
                    this.progress = 100;
                }, (error) => {
                    // Upload error
                    console.error('Upload error:', error);
                    this.isUploading = false;
                }, (event) => {
                    // Upload progress
                    this.progress = event.detail.progress;
                });
                this.isUploading = true;
                this.progress = 0;
            } else {
                alert('Please select a PDF file under 10MB');
            }
        }
    },
    handleFileSelect(event) {
        const file = event.target.files[0];
        if (file) {
            this.isUploading = true;
            this.progress = 0;
        }
    },
    removeUpload(filename) {
        @this.set('file', null);
        document.getElementById('file-upload').value = '';
    }
}" @upload-finished.window="isSubmitting = false" @upload-error.window="isSubmitting = false">
    <form wire:submit.prevent="save" @submit="isSubmitting = true" class="space-y-5">
        <div>
            <x-input-label>Scan Type</x-input-label>
            <select
                required
                wire:model.defer="scanType"
                name="department"
                id="department"
                class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-arm-blue-500 focus:outline-none focus:ring-arm-blue-500 sm:text-sm"
            >
                <option></option>
                <option>Internal</option>
                <option>External</option>
            </select>
        </div>
        <div>
            <x-input-label>Summary Type</x-input-label>
            <select
                required
                wire:model.defer="summaryType"
                name="department"
                id="department"
                class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-arm-blue-500 focus:outline-none focus:ring-arm-blue-500 sm:text-sm"
            >
                <option></option>
                <option>Technical</option>
                <option>Executive</option>
            </select>
        </div>
        <div>
            <x-input-label>Date Ran</x-input-label>
            <x-text-input wire:model.defer="date" class="w-full" type="date" />
        </div>
        <div class="col-span-full">
            <x-input-label>PDF</x-input-label>
            <div
                x-on:drop="isDropping = false"
                x-on:drop.prevent="handleFileDrop($event)"
                x-on:dragover.prevent="isDropping = true"
                x-on:dragleave.prevent="isDropping = false"
                class="mt-2 relative flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
                <div
                    class="absolute top-0 bottom-0 left-0 right-0 z-30 flex items-center justify-center bg-arm-blue-500 opacity-90 x-cloak"
                    x-cloak
                    x-show="isDropping"
                >
                    <span class="text-3xl text-white">Release file to upload!</span>
                </div>
                <div class="text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="mx-auto h-12 w-12 text-gray-300">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                    </svg>
                    <div class="mt-4 flex text-sm leading-6 text-gray-600">
                        <label for="file-upload"
                               class="relative cursor-pointer rounded-md bg-white font-semibold text-arm-blue-600 focus-within:outline-none hover:text-arm-blue-500">
                            <span>Upload a file</span>
                            <input
                                wire:model.defer="file"
                                @change="handleFileSelect"
                                id="file-upload"
                                name="file-upload"
                                type="file"
                                class="sr-only"
                            >
                        </label>
                        <p class="pl-1">or drag and drop</p>
                    </div>
                    <p class="text-xs leading-5 text-gray-600">PDF up to 10MB</p>
                </div>
            </div>
        </div>
        <div x-show="isUploading" x-cloak class="bg-gray-200 h-[2px] w-full mt-3">
            <div
                class="bg-arm-blue-500 h-[2px]"
                style="transition: width 1s"
                :style="{ width: `${progress}%` }"
            >
            </div>
        </div>
        @if($file)
            <div class="flex justify-between">
                <span class="text-sm">{{$file->getClientOriginalName()}}</span>
                <button @click="removeUpload('{{$file->getFilename()}}')" type="button"
                        class="rounded-full bg-red-600 p-1 text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-3 h-3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>

                </button>
            </div>
        @endif
        <x-primary-button x-bind:disabled="isSubmitting">
            <span x-show="!isSubmitting">Submit</span>
            <span x-show="isSubmitting" class="flex items-center">
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Uploading...
            </span>
        </x-primary-button>
    </form>
</div>
