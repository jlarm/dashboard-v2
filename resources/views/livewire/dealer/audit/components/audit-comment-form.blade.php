<div class="border-t border-gray-100">
    <!-- Toggle Button -->
    <div class="px-4 py-3">
        <button
            wire:click="toggleForm"
            type="button"
            class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none
  focus:ring-2 focus:ring-offset-2 focus:ring-arm-blue-500"
        >
            @if($showForm)
                <svg class="-ml-0.5 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
                Hide Comment Form
            @else
                <svg class="-ml-0.5 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Add Comment
            @endif
        </button>
    </div>

    <!-- Comment Form (Collapsible) -->
    @if($showForm)
        <div class="px-4 pb-4 space-y-4">
            <!-- Success Message -->
            @if (session()->has('message'))
                <div class="rounded-md bg-green-50 p-4">
                    <div class="text-sm font-medium text-green-800">
                        {{ session('message') }}
                    </div>
                </div>
            @endif

            <!-- Comment Textarea -->
            <div>
                <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">
                    Comment
                </label>
                <textarea
                    wire:model.defer="comment"
                    id="comment"
                    rows="3"
                    class="block w-full border-gray-300 rounded-md shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"
                    placeholder="Add your comment..."
                ></textarea>
                @error('comment')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Image Upload -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Image (Optional)
                </label>
                
                <div 
                    class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400 transition-colors"
                    x-data="{ 
                        isDragOver: false,
                        handleDrop(e) {
                            this.isDragOver = false;
                            const files = e.dataTransfer.files;
                            if (files.length > 0 && files[0].type.startsWith('image/')) {
                                $wire.upload('image', files[0]);
                            }
                        }
                    }"
                    x-on:dragover.prevent="isDragOver = true"
                    x-on:dragleave.prevent="isDragOver = false"
                    x-on:drop.prevent="handleDrop($event)"
                    :class="{ 'border-arm-blue-500 bg-arm-blue-50': isDragOver }"
                >
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600">
                            <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-arm-blue-600 hover:text-arm-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-arm-blue-500">
                                <span>Upload an image</span>
                                <input 
                                    id="image" 
                                    wire:model="image" 
                                    type="file" 
                                    accept="image/*"
                                    class="sr-only"
                                >
                            </label>
                            <p class="pl-1">or drag and drop</p>
                        </div>
                        <p class="text-xs text-gray-500">
                            PNG, JPG up to 10MB
                        </p>
                    </div>
                </div>
                
                @if ($image)
                    <div class="mt-3">
                        <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-md">
                            <svg class="h-5 w-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-sm text-gray-700 truncate flex-1 min-w-0">
                                Image selected: {{ $image->getClientOriginalName() ?? 'image.jpg' }}
                            </span>
                            <button 
                                type="button" 
                                wire:click="$set('image', null)"
                                class="flex-shrink-0 text-sm text-red-600 hover:text-red-800 font-medium"
                            >
                                Remove
                            </button>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button
                    wire:click="submitComment"
                    type="button"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-arm-blue-600 hover:bg-arm-blue-700 focus:outline-none
  focus:ring-2 focus:ring-offset-2 focus:ring-arm-blue-500"
                    wire:loading.attr="disabled"
                >
                    <span wire:loading.remove>Submit Comment</span>
                    <span wire:loading>
                        <div class="flex items-center gap-1">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Submitting...
                        </div>
                    </span>
                </button>
            </div>
        </div>
    @endif
</div>
