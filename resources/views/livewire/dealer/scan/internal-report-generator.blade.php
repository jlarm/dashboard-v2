<div>
    <div
        class="grid grid-cols-1 md:grid-cols-2 border-b border-gray-200 py-4">
        <div class="flex items-end">

        </div>
        <div class="flex justify-end items-end mt-4 sm:mt-0 space-x-5">
            @if($dealer)
                <span class="sm:block">
                    <button
                        wire:click="export"
                        wire:loading.attr="disabled"
                        type="button"
                        class="flex whitespace-no-wrap px-4 py-2 bg-arm-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-arm-blue-700 focus:bg-arm-blue-700 active:bg-arm-blue-900 focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                    <div wire:loading>
                        <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg"
                             fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                    Generate Report
                </button>
                </span>
            @else
                <div>
                    <p class="text-red-500">Please add the Dealerships name in settings tab to view results.</p>
                </div>
            @endif
        </div>
    </div>
</div>
