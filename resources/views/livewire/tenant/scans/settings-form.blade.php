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
            <x-armp.button
                type="submit"
                :disabled="$isLoading"
                variant="primary"
            >
                <span wire:loading.remove wire:target="save">
                    {{ $store?->cyrisma?->id ? 'Update' : 'Connect' }}
                </span>
                <span wire:loading wire:target="save">
                    Loading
                </span>
            </x-armp.button>
            <x-loading-icon wire:loading wire:target="save" />
        </div>
    </form>
</div>
