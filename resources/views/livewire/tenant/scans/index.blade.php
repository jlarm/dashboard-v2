<div x-data @refresh-page.window="window.location.reload()">
    <x-slot:header>
        <x-slot:pageTitle>Scan Details</x-slot:pageTitle>
        <x-slot:actions>
            <div class="flex items-center gap-2 justify-end">
                @hasanyrole('super-admin|Consultant')
                <x-button.primary href="{{ tenant('locations') ? route('dealer.stores.scan.settings', $store) : route('dealer.scan.settings') }}">Settings</x-button.primary>

{{--                <x-button.secondary--}}
{{--                    href="{{ tenant('locations') ? route('dealer.stores.scan.report', [$store, 'executive']) : route('dealer.scan.report', 'executive') }}?refresh=1"--}}
{{--                    target="_blank"--}}
{{--                    rel="noopener noreferrer"--}}
{{--                    onclick="window.open(this.href, '_blank', 'noopener'); return false;"--}}
{{--                >--}}
{{--                    Executive PDF--}}
{{--                </x-button.secondary>--}}
{{--                <x-button.secondary--}}
{{--                    href="{{ tenant('locations') ? route('dealer.stores.scan.report', [$store, 'technical']) : route('dealer.scan.report', 'technical') }}?refresh=1"--}}
{{--                    target="_blank"--}}
{{--                    rel="noopener noreferrer"--}}
{{--                    onclick="window.open(this.href, '_blank', 'noopener'); return false;"--}}
{{--                >--}}
{{--                    Technical PDF--}}
{{--                </x-button.secondary>--}}
                @endhasanyrole
            </div>
        </x-slot>
    </x-slot:header>

    <div class="space-y-6" wire:init="loadScanData">
        @if($loaded)
            @if($error)
                <!-- Error State -->
                <div class="bg-red-50 border border-red-200 rounded-lg p-6">
                    <div class="flex items-start gap-4">
                        <svg class="w-6 h-6 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <h3 class="text-lg font-semibold text-red-900 mb-1">Connection Error</h3>
                            <p class="text-red-800 mb-4">
                                {{ $error }}
                            </p>
                            <button wire:click="loadScanData" class="inline-flex items-center px-4 py-2 bg-red-100 text-red-700 text-sm font-semibold rounded-lg hover:bg-red-200 border border-red-300">
                                <svg class="w-4 h-4 mr-2" wire:loading.class="animate-spin" wire:target="loadScanData" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                <span wire:loading.remove wire:target="loadScanData">Try Again</span>
                                <span wire:loading wire:target="loadScanData">Retrying...</span>
                            </button>
                        </div>
                    </div>
                </div>
            @elseif($isConfigured && $hasShortName)

                <!-- Overall Risk Dashboard -->
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    @livewire('tenant.scans.components.overall-risk-dashboard', ['cyrisma' => $cyrisma], key('overall-risk-dashboard'))
                </div>

                <!-- Issue Counts Component -->
                @livewire('tenant.scans.components.issue-counts', ['cyrisma' => $cyrisma], key('issue-counts'))

                <!-- External IP Attack Surface -->
                @if($hasExternalScans)
                    <div class="bg-white border border-gray-200 rounded-lg p-6">
                        @livewire('tenant.scans.components.external-ip-exposure', ['cyrisma' => $cyrisma], key('external-ip-exposure'))
                    </div>
                @endif

                <!-- Data Exposure & Baseline Compliance -->
{{--                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">--}}
{{--                    <div class="bg-white border border-gray-200 rounded-lg p-6">--}}
{{--                        @livewire('tenant.scans.components.data-exposure', ['cyrisma' => $cyrisma], key('data-exposure'))--}}
{{--                    </div>--}}
{{--                    <div class="bg-white border border-gray-200 rounded-lg p-6">--}}
{{--                        @livewire('tenant.scans.components.baseline-compliance', ['cyrisma' => $cyrisma], key('baseline-compliance'))--}}
{{--                    </div>--}}
{{--                </div>--}}

                <!-- Vulnerable Assets -->
{{--                <div class="bg-white border border-gray-200 rounded-lg p-6">--}}
{{--                    <div class="flex items-center gap-2 mb-4">--}}
{{--                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-server w-5 h-5 text-indigo-600" aria-hidden="true"><rect width="20" height="8" x="2" y="2" rx="2" ry="2"></rect><rect width="20" height="8" x="2" y="14" rx="2" ry="2"></rect><line x1="6" x2="6.01" y1="6" y2="6"></line><line x1="6" x2="6.01" y1="18" y2="18"></line></svg>--}}
{{--                        <h2 class="text-sm font-black text-slate-900 uppercase tracking-widest">Top Vulnerable Assets</h2>--}}
{{--                    </div>--}}
{{--                    @livewire('tenant.scans.components.vulnerable-assets', ['cyrisma' => $cyrisma], key('vulnerable-assets'))--}}
{{--                </div>--}}

                @if($hasInternalScans)
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
                                @livewire('tenant.scans.components.open-ports', ['cyrisma' => $cyrisma], key('open-ports'))
                            </div>
                        </div>
                        <div>
                            <div class="border p-6 rounded-lg">
                                @livewire('tenant.scans.components.cve-risk-chart', ['cyrisma' => $cyrisma], key('cve-risk-chart'))
                            </div>
                        </div>
                    </div>
                @endif

                @if(!$hasExternalScans && !$hasInternalScans)
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-6">
                        <div class="flex items-start gap-4">
                            <svg class="w-6 h-6 text-gray-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-1">No Scan Results Available</h3>
                                <p class="text-gray-600">
                                    No completed scans were found for this instance. Scan results will appear here once a scan has been completed.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            @elseif(!$isConfigured)
                <!-- API Not Configured Warning -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                    <div class="flex items-start gap-4">
                        <svg class="w-6 h-6 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <div>
                            <h3 class="text-lg font-semibold text-yellow-900 mb-1">API Not Configured</h3>
                            <p class="text-yellow-800">
                                The API credentials have not been configured. Please contact your administrator to set up the API integration to view scan data.
                            </p>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center space-y-5 text-sm">
                    <div class="relative">
                        <p class="absolute inset-0 z-10 flex items-center justify-center px-6 text-center leading-[60px] text-5xl font-bold italic">Contact your consultant <br />today to get started.</p>
                        <img class="opacity-75" src="{{ global_asset('scans.webp') }}" alt="Scans">
                        <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-white to-transparent"></div>
                    </div>
                </div>
            @endif
        @else
            <!-- Loading Skeleton -->
            <div class="bg-gray-200 rounded-lg p-8 animate-pulse"></div>
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
