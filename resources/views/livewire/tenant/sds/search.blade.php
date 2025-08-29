<div>
    <div class="mb-6 space-y-4">
        <div class="space-y-4">
            <div class="flex gap-2">
                <div class="flex-1">
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none z-20 ps-3.5">
                            <svg class="shrink-0 size-4 text-gray-500 dark:text-neutral-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                        </div>
                        <input type="text" wire:model.defer="search" wire:keydown.enter="$refresh" class="py-1 sm:py-1.5 ps-10 pe-8 block w-full bg-gray-100 border-transparent rounded-lg sm:text-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 disabled:opacity-50 disabled:pointer-events-none" placeholder="Search projects">
                        <div class="hidden absolute inset-y-0 end-0 items-center z-20 pe-1">
                            <button type="button" class="inline-flex shrink-0 justify-center items-center size-6 rounded-full text-gray-500 hover:text-arm-blue-600 focus:outline-hidden focus:text-arm-blue-600" aria-label="Close">
                                <span class="sr-only">Close</span>
                                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>
                            </button>
                        </div>
                    </div>
                </div>

                @if(!empty($search) || !empty($manufacturer))
                    <button
                        type="button"
                        wire:click="clearFilters"
                        class="text-xs px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition-colors duration-200"
                    >
                        Clear Search
                    </button>
                @endif

                <x-primary-button class="capitalize" wire:click="$refresh">Search</x-primary-button>
            </div>
        </div>
    </div>

    @if(empty($search))
        <div class="text-center py-12 rounded-lg">
            <svg class="mx-auto size-12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" color="#000000" fill="none">
                <path opacity="0.4" d="M20 13V10.6569C20 9.83935 20 9.4306 19.8478 9.06306C19.6955 8.69552 19.4065 8.40649 18.8284 7.82843L14.0919 3.09188C13.593 2.593 13.3436 2.34355 13.0345 2.19575C12.9702 2.165 12.9044 2.13772 12.8372 2.11401C12.5141 2 12.1614 2 11.4558 2C8.21082 2 6.58831 2 5.48933 2.88607C5.26731 3.06508 5.06508 3.26731 4.88607 3.48933C4 4.58831 4 6.21082 4 9.45584V14C4 17.7712 4 19.6569 5.17157 20.8284C6.23467 21.8915 7.8857 21.99 11 21.9991M13 2.5V3C13 5.82843 13 7.24264 13.8787 8.12132C14.7574 9 16.1716 9 19 9H19.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M20 22L17.8529 19.8529M17.8529 19.8529C17.9675 19.7384 18.0739 19.6158 18.1714 19.486C18.602 18.913 18.8571 18.2006 18.8571 17.4286C18.8571 15.535 17.3221 14 15.4286 14C13.535 14 12 15.535 12 17.4286C12 19.3221 13.535 20.8571 15.4286 20.8571C16.3753 20.8571 17.2325 20.4734 17.8529 19.8529Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
            <p class="mt-1 text-sm text-gray-500">
                Enter a search term and click "Search" to find SDS records.
            </p>
            <p class="text-xs text-gray-400 mt-2">
                You can search by chemical name, manufacturer, or keywords
            </p>
        </div>
    @else
        <div class="overflow-x-auto">
            <x-table class="text-xs">
                <x-slot:head>
                    <x-table.row>
                        <x-table.heading>
                            <button wire:click="sortBy('name')" class="flex items-center hover:text-arm-blue-600" wire:loading.attr="disabled" wire:target="sortBy">
                                <span wire:loading.remove wire:target="sortBy('name')">Name</span>
                                <span wire:loading wire:target="sortBy('name')" class="flex items-center">
                                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-arm-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Name
                                </span>
                                @if($sortField === 'name')
                                    <span class="ml-1" wire:loading.remove wire:target="sortBy">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                @endif
                            </button>
                        </x-table.heading>
                        <x-table.heading>
                            <button wire:click="sortBy('manufacturer')" class="flex items-center hover:text-arm-blue-600" wire:loading.attr="disabled" wire:target="sortBy">
                                <span wire:loading.remove wire:target="sortBy('manufacturer')">Manufacturer</span>
                                <span wire:loading wire:target="sortBy('manufacturer')" class="flex items-center">
                                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-arm-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Manufacturer
                                </span>
                                @if($sortField === 'manufacturer')
                                    <span class="ml-1" wire:loading.remove wire:target="sortBy">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                @endif
                            </button>
                        </x-table.heading>
                        <x-table.heading></x-table.heading>
                    </x-table.row>
                </x-slot:head>
                <x-slot:body>
                    @forelse($sdsRecords as $record)
                        <x-table.row>
                            <x-table.cell>
                                <div class="flex items-center gap-x-2">
                                    <svg class="shrink-0 size-6" width="400" height="492" viewBox="0 0 400 492" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip1)">
                                            <path d="M50.7496 -0.174609C22.9188 -0.174609 -0.0878906 22.4611 -0.0878906 50.6629V440.664C-0.0878906 468.495 22.5478 491.502 50.7496 491.502H349.095C376.926 491.502 399.932 468.866 399.932 440.664V119.683C399.932 119.683 400.675 110.406 396.593 101.129C392.882 92.5945 386.574 86.6573 386.574 86.6573L312.729 13.9263C312.729 13.9263 306.421 7.98906 297.144 3.90722C286.012 -0.916768 274.88 -0.174609 274.88 -0.174609H50.7496Z" fill="currentColor" class="fill-red-500"/>
                                            <path d="M50.7494 16.5238H274.508C274.508 16.5238 283.414 16.5238 290.094 19.4924C296.402 22.09 300.855 26.1718 300.855 26.1718L374.699 98.5317C374.699 98.5317 379.152 103.356 381.378 108.18C383.234 112.262 383.234 119.312 383.234 119.312V119.683V441.035C383.234 459.96 368.02 475.174 349.095 475.174H50.7494C31.8245 475.174 16.6104 459.96 16.6104 441.035V50.6629C16.6104 31.738 31.8245 16.5238 50.7494 16.5238Z" fill="currentColor" class="fill-white"/>
                                            <path d="M99.7314 292.976C88.2281 281.472 100.845 265.887 134.242 248.818L155.393 238.427L163.557 220.245C168.009 210.226 175.06 193.898 178.771 184.25L185.45 166.439L180.626 153.08C174.689 136.752 172.833 112.261 176.544 103.356C181.368 91.4812 197.696 92.5944 204.004 105.582C209.199 115.601 208.457 133.784 202.52 156.791L197.696 175.715L202.148 183.137C204.375 187.219 211.425 196.867 217.363 204.288L228.866 218.389L242.967 216.534C288.238 210.597 303.452 220.616 303.452 235.088C303.452 253.27 267.829 254.755 238.143 233.974C231.464 229.15 227.011 224.698 227.011 224.698C227.011 224.698 208.457 228.408 199.18 231.006C189.532 233.603 185.079 235.088 170.978 239.912C170.978 239.912 166.154 246.962 162.814 252.157C150.94 271.453 137.21 287.038 127.191 292.976C117.172 298.171 105.669 298.542 99.7314 292.976ZM117.914 286.296C124.222 282.214 137.581 267 146.487 252.528L150.198 246.591L133.499 255.126C107.895 268.113 96.0207 280.359 101.958 287.781C105.298 291.862 109.75 291.491 117.914 286.296ZM285.27 239.541C291.578 235.088 290.836 226.182 283.414 222.471C277.848 219.502 273.395 219.131 258.923 219.131C250.017 219.874 235.916 221.358 233.319 222.1C233.319 222.1 241.112 227.666 244.451 229.522C248.904 232.119 260.407 236.943 268.571 239.541C276.735 242.138 281.559 242.138 285.27 239.541ZM217.734 211.339C214.023 207.257 207.344 199.093 203.262 192.785C197.696 185.735 195.098 180.911 195.098 180.911C195.098 180.911 191.016 193.527 188.048 201.32L178.029 226.182L175.06 231.748C175.06 231.748 190.645 226.553 198.438 224.698C206.972 222.471 223.671 219.131 223.671 219.131L217.734 211.339ZM196.211 124.507C197.324 116.343 197.696 108.18 195.098 104.098C187.677 96.3051 179.142 102.613 180.626 121.538C180.997 127.847 182.853 138.979 184.708 145.658L188.419 157.904L191.016 148.627C192.501 143.803 194.727 132.671 196.211 124.507Z" fill="currentColor" class="fill-red-500"/>
                                            <path d="M119.398 346.04H137.952C143.889 346.04 148.713 346.782 152.424 347.895C156.135 349.008 159.104 351.606 161.701 355.316C164.299 359.027 165.412 363.851 165.412 369.046C165.412 373.87 164.299 378.323 162.443 381.663C160.217 385.374 157.619 387.971 154.28 389.455C150.94 390.94 145.374 391.682 138.323 391.682H132.015V420.997H119.398V346.04ZM132.015 355.688V382.034H138.323C143.889 382.034 147.6 380.921 149.827 379.065C152.053 376.839 153.166 373.499 153.166 369.046C153.166 365.707 152.424 362.738 150.94 360.512C149.456 358.285 147.971 357.172 146.487 356.43C145.003 356.059 142.034 355.688 138.694 355.688H132.015Z" fill="currentColor"/>
                                            <path d="M175.431 346.04H192.501C200.664 346.04 207.344 347.524 212.168 350.492C216.992 353.461 220.702 357.543 223.3 363.48C225.898 369.046 227.011 375.726 227.011 382.405C227.011 389.827 225.898 396.506 223.671 402.072C221.445 407.638 218.105 412.462 213.281 415.802C208.828 419.513 202.149 420.997 193.243 420.997H175.431V346.04ZM187.677 356.059V411.349H192.872C200.293 411.349 205.488 408.751 208.828 403.927C212.168 398.732 213.652 392.053 213.652 383.889C213.652 365.336 206.602 356.059 192.872 356.059H187.677Z" fill="currentColor"/>
                                            <path d="M238.885 346.04H280.816V356.059H251.501V378.694H274.879V388.713H251.501V421.368H238.885V346.04Z" fill="currentColor" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip1">
                                                <rect width="400" height="491.75" fill="white"/>
                                            </clipPath>
                                        </defs>
                                    </svg>
                                    {{ Str::title($record->name) }}
                                </div>
                            </x-table.cell>
                            <x-table.cell>
                                {{ Str::title($record->manufacturer) }}
                            </x-table.cell>
                            <x-table.cell class="flex justify-end">
                                <a
                                    href="{{ route('dealer.sds.view', $record->uuid) }}"
                                    target="_blank"
                                    class="py-2 px-2.5 inline-flex items-center gap-x-1.5 text-xs font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-50">
                                    View
                                </a>
                            </x-table.cell>
                        </x-table.row>
                    @empty
                        <tr>
                            <td colspan="5" class="border p-8 text-center">
                                <div class="text-gray-500 text-center">
                                    <p class="text-sm">No SDS records match your search criteria</p>
                                    <button wire:click="clearFilters" class="text-arm-blue-600 hover:underline text-sm mt-1 block mx-auto">
                                        Clear filters to try again
                                    </button>
                                    <x-primary-button class="block capitalize mt-2" onclick="Livewire.emit('modal.open', 'tenant.sds.request-form')">Request SDS Sheet</x-primary-button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </x-slot:body>
            </x-table>
        </div>
        @if($sdsRecords->hasPages())
            <div class="mt-6">
                {{ $sdsRecords->links() }}
            </div>
        @endif
    @endif

    <div wire:loading wire:target="$refresh,manufacturer,sortBy,clearFilters" class="absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center rounded-lg">
        <div class="flex items-center space-x-2">
            <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-arm-blue-600"></div>
            <span class="text-sm text-gray-600">Searching...</span>
        </div>
    </div>
</div>
