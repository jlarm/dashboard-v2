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
            @livewire('tenant.scans.components.cve-list', ['cyrisma' => $cyrisma], key('cve-list'))
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
