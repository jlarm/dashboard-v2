<tr>
    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8">
        {{ $vendor->name }}
    </td>
    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $vendor->contact_name ?? '-' }}</td>
    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"><a
            href="mailto:{{ $vendor->contact_email }}">{{ $vendor->contact_email }}</a></td>
    @if(tenant('locations'))
        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $vendor->store->name ?? '-' }}</td>
    @endif
    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
        @if(\Carbon\Carbon::now() > $vendor->updated_at->addYear() || !$vendor->q1a )
            <span
                class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">Incomplete</span>
        @else
            <span
                class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Current</span>
        @endif
    </td>
    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
        @if($noCount > 0)
            {{ $noCount }}/{{ $totalQuestions }}
        @else
            {{ __('-') }}
        @endif
    </td>
    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
        <div class="flex space-x-3 justify-end items-end">
            @if($vendor->signature)
                <button wire:click.prevent="download" type="button"
                        class="inline-flex items-center gap-x-1.5 rounded-md bg-arm-blue-600 py-1.5 px-2.5 text-sm text-white shadow-sm hover:bg-arm-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-arm-blue-600">
                    <svg wire:loading.remove xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke-width="1.5"
                         stroke="currentColor" class="-ml-0.5 h-5 w-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>
                    </svg>
                    <svg wire:loading class="animate-spin -ml-1 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                         fill="none"
                         viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Download
                </button>
            @endif
            {{--            @if(!$vendor->signature)--}}
            {{--                <button wire:click.prevent="email" type="button" disabled--}}
            {{--                        class="inline-flex items-center gap-x-1.5 rounded-md bg-arm-orange-600 py-1.5 px-2.5 text-sm text-white shadow-sm hover:bg-arm-orange-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-arm-orange-600">--}}
            {{--                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"--}}
            {{--                         stroke="currentColor" class="-ml-0.5 h-5 w-5">--}}
            {{--                        <path stroke-linecap="round" stroke-linejoin="round"--}}
            {{--                              d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>--}}
            {{--                    </svg>--}}
            {{--                    Send--}}
            {{--                </button>--}}
            {{--            @endif--}}
        </div>
    </td>
</tr>
