<div>
    <x-slot:header>
        <x-slot:pageTitle>Scan Details</x-slot:pageTitle>
        <x-slot:actions>
            <button class="inline-flex items-center px-4 py-2 bg-yellow-400 text-gray-900 text-sm font-semibold rounded-lg hover:bg-yellow-500">
                Download report
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
        </x-slot>
    </x-slot:header>

    <div class="space-y-6" wire:init="loadScanData">
        @if($loaded)
            <!-- Issue Counts Component -->
            @livewire('tenant.scans.components.issue-counts', ['cyrisma' => $cyrisma], key('issue-counts'))

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="col-span-2">
                    @livewire('tenant.scans.components.cve-list', ['cyrisma' => $cyrisma], key('cve-list'))
                </div>
                <div>
                    <div class="border p-6 rounded-xl">
                        @livewire('tenant.scans.components.cve-risk-chart', ['cyrisma' => $cyrisma], key('cve-risk-chart'))
                    </div>
                </div>
            </div>
        @else
            <!-- Loading Skeleton -->
            @include('livewire.tenant.scans.components.issue-counts-placeholder')
            <div class="space-y-5">
                <div class="bg-gray-200 rounded-lg p-8 animate-pulse"></div>
                <div class="bg-gray-200 rounded-lg p-8 animate-pulse"></div>
                <div class="bg-gray-200 rounded-lg p-8 animate-pulse"></div>
                <div class="bg-gray-200 rounded-lg p-8 animate-pulse"></div>
            </div>
        @endif
    </div>
</div>
