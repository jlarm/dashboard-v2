<li class="py-4">
    <div class="flex items-end space-x-4">
        @if($manual)
            <div class="min-w-0 flex-1">
                <span class="text-sm text-gray-400">Last Reviewed:</span>
                <p class="truncate text-sm text-gray-800">{{ $manual->assessment_date->format('F d, Y') ?? '' }}</p>
            </div>
            <div class="flex flex-col items-end space-y-3">
                <button type="button" wire:click.prevent="download"
                        class="inline-flex items-center rounded-full border border-gray-300 bg-white px-2.5 py-0.5 text-sm font-medium leading-5 text-gray-700 shadow-sm hover:bg-gray-50">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-4 h-4 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>
                    </svg>
                    Download
                </button>
                @if(\Carbon\Carbon::now() > $manual->assessment_date->addYear() )
                    <a href="#"
                       class="inline-flex items-center rounded-full border border-gray-300 bg-white px-2.5 py-0.5 text-sm font-medium leading-5 text-gray-700 shadow-sm hover:bg-gray-50">
                        Renew
                    </a>
                @endif
            </div>
        @else
            <a href="{{ route('form') }}"
               class="inline-flex items-center rounded-full border border-gray-300 bg-white px-2.5 py-0.5 text-sm font-medium leading-5 text-gray-700 shadow-sm hover:bg-gray-50">
                Start
            </a>
        @endif
    </div>
</li>
