<div x-data="fileUpload">
    <form wire:submit.prevent="save" class="space-y-5">
        <!-- Title -->
        <div>
            <x-input-label for="title" :value="__('PDF Title')"/>
            <x-text-input wire:model.defer="title" id="title" class="block mt-1 w-full shadow-none" type="text"
                          name="title"
                          :value="old('title')" required/>
            @error('title') <p class="text-red-500">{{ $message }}</p> @enderror
        </div>
        <div class="col-span-full">
            <label for="cover-photo" class="block text-sm font-medium leading-6 text-gray-900">Document</label>
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
        @if($file)
            <x-primary-button wire:loading.attr="disabled" wire:loading.class="opacity-25">
                Upload
                <svg wire:loading class="animate-spin ml-1 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                     fill="none"
                     viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </x-primary-button>
        @endif
    </form>
    <script>
        function fileUpload() {
            return {
                isDropping: false,
                isUploading: false,
                progress: 0,
                handleFileSelect(event) {
                    // check if file over 10mb and a pdf
                    if (event.target.files[0].type !== 'application/pdf') {
                        alert('File must be a PDF')
                        return
                    }
                    if (event.target.files[0].size > 10000000) {
                        alert('File must be less than 10MB')
                        return
                    }
                    this.uploadFile(event.target.files)
                },
                handleFileDrop(event) {
                    event.preventDefault()
                    this.isDropping = false
                    // check if file over 10mb and a pdf
                    if (event.dataTransfer.files[0].type !== 'application/pdf') {
                        alert('File must be a PDF')
                        return
                    }
                    if (event.dataTransfer.files[0].size > 10000000) {
                        alert('File must be less than 10MB')
                        return
                    }
                    this.uploadFile(event.dataTransfer.files)
                },
                uploadFile(file) {
                    const $this = this;
                    this.isUploading = true
                    @this.upload('file', file[0], function (success) {
                        $this.isUploading = false
                        $this.progress = 0
                    }, function (error) {
                        console.log('error', error)
                    }, function (event) {
                        $this.progress = event.detail.progress
                    })
                },
                removeUpload(filename) {
                    @this.
                    removeUpload('file', filename)
                },
            }
        }
    </script>
</div>
