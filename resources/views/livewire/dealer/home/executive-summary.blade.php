<div class="h-full">
    <div class="relative overflow-hidden p-3 bg-white border border-gray-200 rounded-xl shadow-sm h-full before:absolute before:top-0 before:end-0 before:size-full before:bg-gradient-to-br before:from-indigo-100 before:via-transparent before:blur-xl">
        <div class="relative z-10 pointer-events-none flex flex-col h-full">
            <div class="flex justify-between items-center gap-x-3 mb-3">
                <span class="inline-flex justify-center items-center size-6 rounded-lg bg-white text-gray-700 shadow">
                    <svg class="flex-shrink-0 size-4 text-indigo-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none">
                        <path d="M9 12H15M9 8H15M9 16H12M5 22H19C20.1046 22 21 21.1046 21 20V4C21 2.89543 20.1046 2 19 2H5C3.89543 2 3 2.89543 3 4V20C3 21.1046 3.89543 22 5 22Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
            </div>

            <h2 class="text-sm text-gray-800">Executive Summary</h2>
            <p class="text-xs text-gray-400 mt-0.5">{{ now()->format('F Y') }}</p>

            <div class="mt-auto pointer-events-auto">
                <x-armp.button wire:click="download" type="button" size="xs" class="w-full">
                    <span wire:loading.remove wire:target="download">Download Report</span>
                    <span wire:loading.inline-flex wire:target="download" class="flex-row items-center justify-center gap-1 whitespace-nowrap leading-none">
                        <x-loading-icon class="!-ml-0 !mr-0 !size-2 shrink-0" />
                        <span class="inline-block">Generating...</span>
                    </span>
                </x-armp.button>
            </div>
        </div>
    </div>
</div>
