<div>
    <x-slot:header>
        <x-slot:pageTitle>Scan Details</x-slot:pageTitle>
        <x-slot:actions>
            @hasanyrole('super-admin|Consultant')
            <x-button.primary :href="route('dealer.cyrisma.settings')">Settings</x-button.primary>
            @endhasanyrole
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
                    <div class="col-span-2 space-y-3">
                        <div class="border p-6 rounded-lg">
                            <div class="flex items-center gap-2 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield-alert w-5 h-5 text-indigo-600" aria-hidden="true"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path><path d="M12 8v4"></path><path d="M12 16h.01"></path></svg>
                                <h2 class="text-sm font-black text-slate-900 uppercase tracking-widest">Security Vulnerabilities</h2>
                            </div>
                            @livewire('tenant.scans.components.cve-list', ['cyrisma' => $cyrisma], key('cve-list'))
                        </div>
                        <div class="border p-6 rounded-lg">
                            <div class="flex items-center gap-2 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layers w-5 h-5 text-indigo-600" aria-hidden="true"><path d="M12.83 2.18a2 2 0 0 0-1.66 0L2.6 6.08a1 1 0 0 0 0 1.83l8.58 3.91a2 2 0 0 0 1.66 0l8.58-3.9a1 1 0 0 0 0-1.83z"></path><path d="M2 12a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 12"></path><path d="M2 17a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 17"></path></svg>
                                <h2 class="text-sm font-black text-slate-900 uppercase tracking-widest">Open Port Vulnerabilities</h2>
                            </div>
                            @livewire('tenant.scans.components.open-ports', ['cyrisma' => $cyrisma], key('cve-list'))
                        </div>
                    </div>
                    <div>
                        <div class="border p-6 rounded-lg">
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
