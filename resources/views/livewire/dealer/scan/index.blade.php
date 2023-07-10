<div>
    <div
        class="grid grid-cols-1 md:grid-cols-2 border-b border-gray-200 px-4 py-4 sm:px-6 lg:px-8">
        <div class="flex items-end">
            <h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">Scan Reports</h1>
        </div>
        <div class="flex justify-end items-end mt-4 sm:mt-0 space-x-5">
            @if($dealer)
                <select
                    wire:model.defer="type"
                    id="location"
                    name="location"
                    class="mt-2 block rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-arm-blue-600 sm:text-sm sm:leading-6">
                    @if(!$tech || $tech->created_at->format('Ymd') != Carbon\Carbon::now()->format('Ymd'))
                        <option value="technical">Technical Report</option>
                    @endif
                    @if(!$exec || $exec->created_at->format('Ymd') != Carbon\Carbon::now()->format('Ymd'))
                        <option value="executive">Executive Report</option>
                    @endif
                </select>

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
{{--                    <div wire:loading.remove>--}}
                        {{--                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"--}}
                        {{--                                                     stroke-width="1.5"--}}
                        {{--                                                     stroke="currentColor" class="w-4 h-4 mr-2">--}}
                        {{--                                                    <path stroke-linecap="round" stroke-linejoin="round"--}}
                        {{--                                                          d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m.75 12l3 3m0 0l3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>--}}
                        {{--                                                </svg>--}}
                        {{--                                            </div>--}}
                    Generate Report
                </button>
                </span>
            @else
                <div>
                    <p class="text-red-500">Please add the Dealerships name in settings to view results.</p>
                </div>
            @endif
            <span class="sm:block">
                <a
                    class="inline-flex items-center px-4 py-2 bg-white border border-transparent rounded-md font-semibold text-xs text-arm-500 uppercase ring-1 ring-gray-300 tracking-widest hover:bg-gray-50 transition ease-in-out duration-150"
                    href="{{ route('dealer.scan.settings') }}">
                Settings
            </a>
            </span>
        </div>
    </div>
</div>
