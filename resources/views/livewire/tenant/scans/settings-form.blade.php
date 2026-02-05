<div class="max-w-3xl mx-auto">
    @if($successMessage)
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ $successMessage }}</span>
        </div>
    @endif

    @if($errorMessage)
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 rounded px-4 py-3 relative" role="alert">
            <span class="block sm:inline">{{ $errorMessage }}</span>
        </div>
    @endif

    <form wire:submit.prevent="save" class="space-y-5">
        <div>
            <x-input-label for="instanceId">Instance ID</x-input-label>
            <x-text-input class="block w-full mt-1" id="instanceId" wire:model.defer="instanceId" type="text" />
        </div>
        <div class="flex items-center gap-3">
            <x-primary-button
                type="submit"
                :disabled="$isLoading"
                class="relative"
            >
                  <span wire:loading.remove wire:target="save">
                      {{ $store->cyrisma ? 'Update Configuration' : 'Connect Instance' }}
                  </span>
                <span wire:loading wire:target="save">
                      Searching...
                  </span>
            </x-primary-button>

            {{-- Loading Spinner --}}
            <div wire:loading wire:target="save" class="flex items-center text-gray-600">
                <svg class="animate-spin h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-sm">Please wait...</span>
            </div>
        </div>
    </form>
</div>
