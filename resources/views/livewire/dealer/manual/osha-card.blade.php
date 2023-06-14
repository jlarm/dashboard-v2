<div class="bg-gray-50 border border-gray-300 overflow-hidden rounded-lg hover:shadow-xl transition">
    <div class="p-6 text-gray-900">
        <h2 class="text-2xl font-bold mb-5">OSHA</h2>
        <div class="flow-root">
            <ul role="list" class="-my-5 divide-y divide-gray-200">
                <li class="py-4">
                    <div class="flex items-end space-x-4">
                        @if($osha)
                            <div class="min-w-0 flex-1">
                                <span class="text-sm text-gray-400">Last Reviewed:</span>
                                <p class="truncate text-sm text-gray-800">{{ $osha->created_at->format('F d, Y') }}</p>
                            </div>
                        @else
                            <div class="min-w-0 flex-1">
                                <a href="@if(!tenant('locations')) {{ route('dealer.manual.osha') }} @else {{ route('dealer.stores.manuals.osha', $store) }} @endif"
                                   class="inline-flex items-center rounded-full border border-gray-300 bg-white px-2.5 py-0.5 text-sm font-medium leading-5 text-gray-700 shadow-sm hover:bg-gray-50">
                                    Start
                                </a>
                            </div>
                        @endif
                        @if($osha)
                            <div class="flex flex-col items-end space-y-3">
                                <a wire:click.prevent="download" wire:loading.attr="disabled"
                                   class="inline-flex items-center rounded-full border border-gray-300 bg-white px-2.5 py-0.5 text-sm font-medium leading-5 text-gray-700 shadow-sm hover:bg-gray-50">
                                    <svg wire:loading.remove xmlns="http://www.w3.org/2000/svg" fill="none"
                                         viewBox="0 0 24 24" stroke-width="1.5"
                                         stroke="currentColor" class="w-4 h-4 mr-2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>
                                    </svg>
                                    <svg wire:loading
                                         class="animate-spin w-4 h-4 mr-2 text-gray-300 hover:cursor-pointer"
                                         xmlns="http://www.w3.org/2000/svg"
                                         fill="none"
                                         viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Download
                                </a>
                            </div>
                        @endif
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
