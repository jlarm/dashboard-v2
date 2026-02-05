<div>
    <div class="mb-4">
        <select wire:model="assetType" class="block w-full max-w-xs rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-arm-blue-600 sm:text-sm sm:leading-6">
            <option value="">All Asset Types</option>
            <option value="internal">Internal Authenticated</option>
            <option value="external_ip">External - IP Addresses</option>
        </select>
    </div>

    <x-table>
        <x-slot:head>
            <x-table.row>
                <x-table.heading>Port</x-table.heading>
                <x-table.heading>Description</x-table.heading>
                <x-table.heading>Risk Level</x-table.heading>
                <x-table.heading class="text-right">No. of Machines</x-table.heading>
            </x-table.row>
        </x-slot:head>
        <x-slot:body>
            @forelse($paginatedPorts as $openPort)
                <x-table.row wire:key="port-{{ $openPort['portNumber'] }}">
                    <x-table.cell>
                        {{ $openPort['portNumber'] }}
                    </x-table.cell>
                    <x-table.cell>
                        {{ $openPort['portDescription'] }}
                    </x-table.cell>
                    <x-table.cell>
                        @if($openPort['riskLevel'] === 'Medium')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider border bg-orange-50 text-orange-600 border-orange-100">
                                {{ $openPort['riskLevel'] }}
                            </span>
                        @elseif($openPort['riskLevel'] === 'High')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider border bg-red-50 text-red-600 border-red-100">
                                {{ $openPort['riskLevel'] }}
                            </span>
                        @elseif($openPort['riskLevel'] === 'Critical')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider border bg-red-50 text-red-700 border-red-200">
                                {{ $openPort['riskLevel'] }}
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider border bg-emerald-50 text-emerald-600 border-emerald-100">
                                {{ $openPort['riskLevel'] }}
                            </span>
                        @endif
                    </x-table.cell>
                    <x-table.cell class="text-right">
                        {{ $openPort['machineCount'] }}
                    </x-table.cell>
                </x-table.row>
            @empty
                <x-table.row>
                    <x-table.cell colspan="4" class="text-center text-gray-500">
                        No open ports found.
                    </x-table.cell>
                </x-table.row>
            @endforelse
        </x-slot:body>
    </x-table>

    @if($totalPages > 1)
        <div class="mt-5 flex justify-center">
            <nav class="flex items-center gap-x-1" aria-label="Pagination">
                <button wire:click="previousPage" type="button" class="min-h-9.5 min-w-9.5 py-2 px-2.5 inline-flex justify-center items-center gap-x-1.5 text-sm rounded-lg text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none" aria-label="Previous" @if($currentPage <= 1) disabled @endif>
                    <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m15 18-6-6 6-6"></path>
                    </svg>
                    <span>Previous</span>
                </button>

                <div class="flex items-center gap-x-1">
                    @php
                        $showPages = [];
                        $showPages[] = 1;

                        if($currentPage > 4) {
                            $showPages[] = '...';
                        }

                        for($i = max(2, $currentPage - 2); $i <= min($currentPage + 2, $totalPages - 1); $i++) {
                            if($i !== 1 && $i !== $totalPages) {
                                $showPages[] = $i;
                            }
                        }

                        if($currentPage < $totalPages - 3) {
                            $showPages[] = '...';
                        }

                        if($totalPages > 1) {
                            $showPages[] = $totalPages;
                        }

                        $showPages = array_unique($showPages);
                    @endphp

                    @foreach($showPages as $index => $page)
                        @if($page === '...')
                            <div wire:key="ellipsis-{{ $index }}" class="min-h-9.5 flex justify-center items-center text-gray-800 py-2 px-1.5 text-sm">...</div>
                        @elseif($page === $currentPage)
                            <button wire:key="current-{{ $page }}" type="button" class="min-h-9.5 min-w-9.5 flex justify-center items-center bg-gray-200 text-gray-800 py-2 px-3 text-sm rounded-lg focus:outline-hidden focus:bg-gray-300 disabled:opacity-50 disabled:pointer-events-none" aria-current="page">{{ $page }}</button>
                        @else
                            <button wire:key="button-{{ $page }}" wire:click.prevent="gotoPage({{ $page }})" type="button" class="min-h-9.5 min-w-9.5 flex justify-center items-center text-gray-800 hover:bg-gray-100 py-2 px-3 text-sm rounded-lg focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none">{{ $page }}</button>
                        @endif
                    @endforeach
                </div>

                <button wire:click="nextPage" type="button" class="min-h-9.5 min-w-9.5 py-2 px-2.5 inline-flex justify-center items-center gap-x-1.5 text-sm rounded-lg text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none" aria-label="Next" @if($currentPage >= $totalPages) disabled @endif>
                    <span>Next</span>
                    <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m9 18 6-6-6-6"></path>
                    </svg>
                </button>
            </nav>
        </div>
    @endif
</div>
