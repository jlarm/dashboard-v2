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
            @if($isConfigured)
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
                <!-- Configuration Warning -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                    <div class="flex items-start gap-4">
                        <svg class="w-6 h-6 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <div>
                            <h3 class="text-lg font-semibold text-yellow-900 mb-1">Cyrisma API Not Configured</h3>
                            <p class="text-yellow-800">
                                The Cyrisma API credentials have not been configured. Please contact your administrator to set up the API integration to view scan data.
                            </p>
                        </div>
                    </div>
                </div>
            @endif
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
