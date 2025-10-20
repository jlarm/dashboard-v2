<x-wire-elements-pro::tailwind.modal on-submit="generate">
    <x-slot name="title">Generate Deal Jacket Report</x-slot>

    <div class="space-y-4">
        @if($errors->has('generation'))
            <div class="rounded-lg bg-red-50 p-4">
                <div class="flex">
                    <div class="shrink-0">
                        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-800">{{ $errors->first('generation') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="text-sm text-gray-600">
            <p>This will generate a comprehensive PDF report for the deal jacket group:</p>

            <div class="mt-4 rounded-lg bg-gray-50 p-4 space-y-2">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-700">Store:</span>
                    <span class="text-sm text-gray-900">{{ $dealJacketGroup->store->name }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-700">Date:</span>
                    <span class="text-sm text-gray-900">{{ $dealJacketGroup->created_at->format('M d, Y') }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-700">Deal Jackets:</span>
                    <span class="text-sm text-gray-900">{{ $dealJacketGroup->deal_jackets_count }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-700">Total Issues:</span>
                    <span class="text-sm font-semibold text-red-600">{{ $dealJacketGroup->total_failed ?? 0 }}</span>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="buttons">
        <x-primary-button type="submit" wire:loading.attr="disabled" wire:target="generate">
            <span wire:loading.remove wire:target="generate">Generate Report</span>
            <span wire:loading wire:target="generate" class="flex items-center">
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Generating...
            </span>
        </x-primary-button>
        <x-secondary-button type="button" wire:click="$emit('modal.close')" wire:loading.attr="disabled">
            Cancel
        </x-secondary-button>
    </x-slot>
</x-wire-elements-pro::tailwind.modal>
