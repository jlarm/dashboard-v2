<div class="flex gap-3 items-center">
    <x-primary-button wire:click="download" wire:loading.attr="disabled">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" color="#ffffff" fill="none">
            <path d="M12 4.5L12 13.9643M9 11.4998L12 14.5L15 11.4998" stroke="currentColor" stroke-width="1.5" />
            <path d="M20 16.5L19 19.5H5L4 16.5" stroke="currentColor" stroke-width="1.5" />
        </svg>
        Download PDF</x-primary-button>
    <svg wire:loading class="animate-spin -ml-1 mr-3 h-5 w-5 text-arm-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
    </svg>
</div>
