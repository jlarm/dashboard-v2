<div x-data="{ openAccordion: null }">
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    External IP Attack Surface
                </h3>
                <p class="text-sm text-gray-600">External scan assets and their vulnerabilities</p>
            </div>
            @if(!empty($scanInfo))
                <div class="text-right text-xs text-gray-500">
                    <div>Last scanned: {{ $scanInfo['scan_finished'] ?? '-' }}</div>
                    <div class="font-medium text-gray-700 mt-1">{{ count($externalAssets) }} external {{ Str::plural('asset', count($externalAssets)) }} found</div>
                </div>
            @endif
        </div>
    </div>

    @if(empty($externalAssets))
        <div class="border-2 border-dashed border-gray-300 rounded-lg p-12 text-center">
            <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No External Scan Data Found</h3>
            <p class="text-gray-600">No external IP scan data is available. External scans help identify your internet-facing attack surface.</p>
        </div>
    @else
        <div class="space-y-2.5">
            @foreach($externalAssets as $index => $asset)
                @php
                    $findings = $this->getFindingsBySeverity($asset);
                    $counts = $this->getVulnerabilityCounts($asset);
                    $total = count($findings);
                    $color = $this->getRiskColor($counts['critical'], $counts['high']);
                    $openPorts = $asset['openPorts'] ?? [];
                    $assetId = $asset['ipAddress'] ?? $index;
                @endphp

                <div wire:key="asset-{{ $assetId }}">
                    <!-- Accordion Header Button -->
                    <button
                        @click="openAccordion = openAccordion === '{{ $assetId }}' ? null : '{{ $assetId }}'"
                        class="w-full text-left p-4 border rounded-lg hover:bg-gray-50 transition-colors"
                        :class="{ 'bg-gray-50 border-{{ $color }}-300': openAccordion === '{{ $assetId }}', 'border-gray-200': openAccordion !== '{{ $assetId }}' }"
                    >
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <svg
                                    class="shrink-0 w-4 h-4 transition-transform duration-200"
                                    :class="{ 'rotate-90': openAccordion === '{{ $assetId }}' }"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                                <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-lg bg-{{ $color }}-100">
                                    <svg class="w-5 h-5 text-{{ $color }}-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-gray-900">{{ $asset['name'] ?? $asset['ipAddress'] ?? 'Unknown Asset' }}</div>
                                    <div class="flex items-center gap-2 text-sm text-gray-600">
                                        <span>{{ $asset['ipAddress'] ?? '-' }}</span>
                                        @if(!empty($openPorts))
                                            <span class="text-gray-400">|</span>
                                            <span>{{ count($openPorts) }} open {{ Str::plural('port', count($openPorts)) }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                @if($total > 0)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-{{ $color }}-100 text-{{ $color }}-800">
                                        {{ $total }} {{ Str::plural('vulnerability', $total) }}
                                    </span>
                                @endif

                                <!-- Risk Level Indicator -->
                                @if($counts['critical'] > 0)
                                    <span class="flex items-center gap-x-2">
                                        <span class="flex items-center gap-0.5">
                                            <span class="shrink-0 w-1 h-3.5 inline-block bg-red-500 rounded-full"></span>
                                            <span class="shrink-0 w-1 h-3.5 inline-block bg-red-500 rounded-full"></span>
                                            <span class="shrink-0 w-1 h-3.5 inline-block bg-red-500 rounded-full"></span>
                                            <span class="shrink-0 w-1 h-3.5 inline-block bg-red-500 rounded-full"></span>
                                        </span>
                                        <span class="text-sm text-gray-600">Critical</span>
                                    </span>
                                @elseif($counts['high'] > 0)
                                    <span class="flex items-center gap-x-2">
                                        <span class="flex items-center gap-0.5">
                                            <span class="shrink-0 w-1 h-3.5 inline-block bg-orange-400 rounded-full"></span>
                                            <span class="shrink-0 w-1 h-3.5 inline-block bg-orange-400 rounded-full"></span>
                                            <span class="shrink-0 w-1 h-3.5 inline-block bg-orange-400 rounded-full"></span>
                                            <span class="shrink-0 w-1 h-3.5 inline-block bg-gray-300 rounded-full"></span>
                                        </span>
                                        <span class="text-sm text-gray-600">High</span>
                                    </span>
                                @elseif($counts['medium'] > 0)
                                    <span class="flex items-center gap-x-2">
                                        <span class="flex items-center gap-0.5">
                                            <span class="shrink-0 w-1 h-3.5 inline-block bg-yellow-400 rounded-full"></span>
                                            <span class="shrink-0 w-1 h-3.5 inline-block bg-yellow-400 rounded-full"></span>
                                            <span class="shrink-0 w-1 h-3.5 inline-block bg-gray-300 rounded-full"></span>
                                            <span class="shrink-0 w-1 h-3.5 inline-block bg-gray-300 rounded-full"></span>
                                        </span>
                                        <span class="text-sm text-gray-600">Medium</span>
                                    </span>
                                @elseif($counts['low'] > 0)
                                    <span class="flex items-center gap-x-2">
                                        <span class="flex items-center gap-0.5">
                                            <span class="shrink-0 w-1 h-3.5 inline-block bg-gray-400 rounded-full"></span>
                                            <span class="shrink-0 w-1 h-3.5 inline-block bg-gray-300 rounded-full"></span>
                                            <span class="shrink-0 w-1 h-3.5 inline-block bg-gray-300 rounded-full"></span>
                                            <span class="shrink-0 w-1 h-3.5 inline-block bg-gray-300 rounded-full"></span>
                                        </span>
                                        <span class="text-sm text-gray-600">Low</span>
                                    </span>
                                @else
                                    <span class="flex items-center gap-x-2">
                                        <span class="flex items-center gap-0.5">
                                            <span class="shrink-0 w-1 h-3.5 inline-block bg-green-400 rounded-full"></span>
                                            <span class="shrink-0 w-1 h-3.5 inline-block bg-gray-300 rounded-full"></span>
                                            <span class="shrink-0 w-1 h-3.5 inline-block bg-gray-300 rounded-full"></span>
                                            <span class="shrink-0 w-1 h-3.5 inline-block bg-gray-300 rounded-full"></span>
                                        </span>
                                        <span class="text-sm text-gray-600">Clean</span>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </button>

                    <!-- Accordion Content -->
                    <div x-show="openAccordion === '{{ $assetId }}'" x-collapse class="overflow-hidden">
                        <div class="px-6 py-4 border border-t-0 border-gray-200 rounded-b-lg bg-white">
                            <!-- Open Ports -->
                            @if(!empty($openPorts))
                                <div class="mb-4">
                                    <h5 class="text-sm font-semibold text-gray-900 mb-3 flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"/>
                                        </svg>
                                        Open Ports ({{ count($openPorts) }})
                                    </h5>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($openPorts as $port)
                                            @php
                                                $portRisk = strtolower($port['riskLevel'] ?? 'medium');
                                                $portColor = match($portRisk) {
                                                    'critical' => 'red',
                                                    'high' => 'orange',
                                                    'low' => 'gray',
                                                    default => 'yellow'
                                                };
                                            @endphp
                                            <div class="inline-flex items-center bg-{{ $portColor }}-100 border border-{{ $portColor }}-300 rounded-lg px-3 py-2">
                                                <span class="text-sm font-bold text-{{ $portColor }}-900">{{ $port['portNumber'] }}</span>
                                                @if(!empty($port['portDescription']))
                                                    <span class="text-xs text-{{ $portColor }}-700 ml-2">{{ $port['portDescription'] }}</span>
                                                @endif
                                                <span class="inline-flex items-center ml-2 px-1.5 py-0.5 rounded text-xs font-medium bg-{{ $portColor }}-200 text-{{ $portColor }}-900">
                                                    {{ ucfirst($port['riskLevel'] ?? 'Unknown') }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Vulnerability Findings -->
                            @if(!empty($findings))
                                <div>
                                    <h5 class="text-sm font-semibold text-gray-900 mb-3">Vulnerability Findings</h5>
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-200 border border-gray-200 rounded-lg overflow-hidden">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700 uppercase tracking-wide">Flaw</th>
                                                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700 uppercase tracking-wide">Risk Level</th>
                                                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700 uppercase tracking-wide">Affected URLs</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-100">
                                        @foreach($findings as $findingIndex => $finding)
                                            @php
                                                $findingRisk = strtolower($finding['riskLevel'] ?? 'medium');
                                                $findingColor = match($findingRisk) {
                                                    'critical' => 'red',
                                                    'high' => 'orange',
                                                    'medium' => 'yellow',
                                                    'low' => 'green',
                                                    'info' => 'blue',
                                                    default => 'gray'
                                                };
                                            @endphp
                                            <tr
                                                wire:click="openFindingModal({{ $index }}, {{ $findingIndex }})"
                                                class="cursor-pointer hover:bg-gray-50 transition-colors"
                                            >
                                                <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $finding['name'] ?? 'Unknown Finding' }}</td>
                                                <td class="px-4 py-3">
                                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-bold bg-{{ $findingColor }}-100 text-{{ $findingColor }}-800 border border-{{ $findingColor }}-300">
                                                        {{ ucfirst($finding['riskLevel'] ?? 'Unknown') }}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-3 text-sm text-gray-700">{{ $finding['affectedUrls'] ?? 0 }}</td>
                                            </tr>
                                        @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-4 text-gray-500">
                                    <svg class="w-8 h-8 mx-auto mb-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <p class="text-sm">No vulnerabilities detected for this asset</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    @if($isFindingModalOpen && !empty($selectedFinding))
        <div
            class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4"
            aria-modal="true"
            role="dialog"
            wire:click.self="closeFindingModal"
        >
            <div class="absolute inset-0 bg-gray-900/40" wire:click="closeFindingModal"></div>

            <div class="relative w-full max-w-4xl max-h-[88vh] overflow-y-auto rounded-xl border border-gray-200 bg-white shadow-2xl">
                <div class="sticky top-0 z-10 border-b border-gray-200 bg-white px-4 py-3">
                    <div class="flex items-start justify-between gap-4">
                        <div class="min-w-0">
                            <h4 class="text-lg font-semibold text-gray-900">{{ $selectedFinding['name'] ?? 'Finding Details' }}</h4>
                            <div class="mt-2">
                                @php
                                    $selectedFindingRisk = strtolower($selectedFinding['riskLevel'] ?? 'info');
                                    $selectedFindingColor = match($selectedFindingRisk) {
                                        'critical' => 'red',
                                        'high' => 'orange',
                                        'medium' => 'yellow',
                                        'low' => 'green',
                                        'info' => 'blue',
                                        default => 'gray'
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-{{ $selectedFindingColor }}-100 text-{{ $selectedFindingColor }}-800 border border-{{ $selectedFindingColor }}-300">
                                    Risk Level: {{ ucfirst($selectedFinding['riskLevel'] ?? 'Unknown') }}
                                </span>
                            </div>
                        </div>

                        <button
                            type="button"
                            wire:click="closeFindingModal"
                            class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-2.5 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50"
                        >
                            Close
                        </button>
                    </div>
                </div>

                <div class="p-4 space-y-4">
                    @if(!empty($selectedFinding['description']))
                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                            <h5 class="text-lg font-semibold text-gray-900 mb-2">Description</h5>
                            <p class="text-sm leading-relaxed text-gray-800 whitespace-pre-line">{{ $selectedFinding['description'] }}</p>
                        </div>
                    @endif

                    @if(!empty($selectedFinding['solution']) || !empty($selectedFinding['references']))
                        <div class="rounded-xl border border-gray-200 bg-white p-4">
                            @if(!empty($selectedFinding['solution']))
                                <h5 class="text-lg font-semibold text-gray-900 mb-2">Solution</h5>
                                <p class="text-sm leading-relaxed text-gray-800 whitespace-pre-line">{{ $selectedFinding['solution'] }}</p>
                            @endif

                            @if(!empty($selectedFinding['references']))
                                <div class="{{ !empty($selectedFinding['solution']) ? 'mt-5' : '' }}">
                                    <h6 class="text-sm font-semibold text-gray-900 mb-2">Reference Links</h6>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($selectedFinding['references'] as $reference)
                                            @php
                                                $referenceUrl = filter_var($reference, FILTER_VALIDATE_URL) ? $reference : null;
                                            @endphp
                                            @if($referenceUrl)
                                                <a
                                                    href="{{ $referenceUrl }}"
                                                    target="_blank"
                                                    rel="noopener noreferrer"
                                                    class="inline-flex max-w-full items-center rounded-lg border border-blue-300 bg-blue-50 px-3 py-1.5 text-xs font-medium text-blue-700 hover:bg-blue-100"
                                                >
                                                    <span class="truncate">{{ $referenceUrl }}</span>
                                                </a>
                                            @else
                                                <span class="inline-flex max-w-full items-center rounded-lg border border-gray-300 bg-gray-50 px-3 py-1.5 text-xs text-gray-700">
                                                    <span class="truncate">{{ $reference }}</span>
                                                </span>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif

                    @if(!empty($selectedFinding['instances']))
                        <div class="overflow-x-auto rounded-xl border border-gray-200">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2.5 text-left text-[11px] font-semibold text-gray-700 uppercase tracking-wide">URL</th>
                                        <th class="px-4 py-2.5 text-left text-[11px] font-semibold text-gray-700 uppercase tracking-wide">Method</th>
                                        <th class="px-4 py-2.5 text-left text-[11px] font-semibold text-gray-700 uppercase tracking-wide">Parameters</th>
                                        <th class="px-4 py-2.5 text-left text-[11px] font-semibold text-gray-700 uppercase tracking-wide">Attack</th>
                                        <th class="px-4 py-2.5 text-left text-[11px] font-semibold text-gray-700 uppercase tracking-wide">Evidence</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 bg-white">
                                    @foreach($selectedFinding['instances'] as $instance)
                                        <tr>
                                            <td class="px-4 py-2.5 text-xs text-gray-900">{{ $instance['url'] ?? '-' }}</td>
                                            <td class="px-4 py-2.5 text-xs text-gray-700">{{ $instance['method'] ?? '-' }}</td>
                                            <td class="px-4 py-2.5 text-xs text-gray-700">{{ $instance['parameters'] ?? '-' }}</td>
                                            <td class="px-4 py-2.5 text-xs text-gray-700">{{ $instance['attack'] ?? '-' }}</td>
                                            <td class="px-4 py-2.5 text-xs text-gray-700">{{ $instance['evidence'] ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
