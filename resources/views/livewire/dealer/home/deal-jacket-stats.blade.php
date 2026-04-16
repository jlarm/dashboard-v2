<div class="h-full">
    <div class="relative overflow-hidden p-3 bg-white border border-gray-200 rounded-xl shadow-sm h-full before:absolute before:top-0 before:end-0 before:size-full before:bg-gradient-to-br before:from-green-100 before:via-transparent before:blur-xl">
        <a
            href="{{ route('dealer.audit.deal-jackets.index') }}"
            class="absolute inset-0 z-0"
            aria-label="View deal jacket audits"
        ></a>

        <div class="relative z-10 pointer-events-none flex flex-col h-full">
            <div class="flex justify-between items-center gap-x-3 mb-3">
                <span class="inline-flex justify-center items-center size-6 rounded-lg bg-white text-gray-700 shadow">
                    <svg class="flex-shrink-0 size-4 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none">
                        <path d="M22 21L12 3L2 21H22Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                        <path d="M12 15L12 10M12 16.5L12 18" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                    </svg>
                </span>
            </div>

            <h2 class="text-sm text-gray-800">Deal Jacket Rating</h2>

            <h3 class="text-base font-semibold text-gray-800 mt-2 mb-2">{{ $this->rating() }}</h3>

            <div class="mt-auto">
                @if($this->canDownload())
                    <div class="pointer-events-auto">
                        <x-armp.button wire:click.stop="download" type="button" size="xs" class="w-full">
                            <span wire:loading.remove wire:target="download">Download Report</span>
                            <span wire:loading.inline-flex wire:target="download" class="flex-row items-center justify-center gap-1 whitespace-nowrap leading-none">
                                <x-loading-icon class="!-ml-0 !mr-0 !size-2 shrink-0" />
                                <span class="inline-block">Loading...</span>
                            </span>
                        </x-armp.button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
