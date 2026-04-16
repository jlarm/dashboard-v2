<div class="md:col-span-2 h-full">
    <div class="relative overflow-hidden p-3 bg-white border border-gray-200 rounded-xl shadow-sm h-full">
        <div class="relative z-10 flex flex-col h-full">
            <h2 class="text-sm text-gray-800">Group Executive Summary</h2>

            <div class="mt-auto">
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
