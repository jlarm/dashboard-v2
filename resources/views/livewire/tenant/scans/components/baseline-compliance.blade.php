<div>
    <div class="mb-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Baseline Configuration Compliance</h3>
                <p class="text-sm text-gray-600">CIS Security Benchmarks compliance status</p>
            </div>
            <div class="text-right">
                <div class="text-sm text-gray-600 mb-1">Current Grade</div>
                <div class="flex items-center gap-2">
                    <span class="text-3xl font-bold text-gray-900">{{ $currentGrade }}</span>
                    @php
                        $trend = $this->getGradeTrend();
                    @endphp
                    @if($trend === 'improved')
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                    @elseif($trend === 'declined')
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/>
                        </svg>
                    @endif
                </div>
                <div class="text-xs text-gray-500 mt-1">Previous: {{ $previousGrade }}</div>
            </div>
        </div>
    </div>

    @if(empty($systems))
        <div class="text-center py-8 text-gray-500">
            <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p>No baseline compliance data available</p>
        </div>
    @else
        <div class="space-y-3">
            <h4 class="text-sm font-medium text-gray-700 mb-3">Systems with Lowest Compliance</h4>
            @foreach($systems as $system)
                @php
                    $passRate = $system['pass_rate'] ?? 0;
                    $color = $this->getPassRateColor($passRate);
                @endphp
                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-lg bg-{{ $color }}-100">
                                    <svg class="w-5 h-5 text-{{ $color }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h5 class="text-sm font-semibold text-gray-900">{{ $system['name'] ?? 'Unknown' }}</h5>
                                    <p class="text-xs text-gray-500">{{ $system['ip'] ?? '-' }}</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4 mt-3">
                                <div>
                                    <div class="text-xs text-gray-600 mb-1">Profile</div>
                                    <div class="text-sm font-medium text-gray-900">{{ $system['profile_name'] ?? '-' }}</div>
                                    <div class="text-xs text-gray-500">{{ $system['profile_type'] ?? '-' }}</div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-600 mb-1">Last Scanned</div>
                                    <div class="text-sm text-gray-900">{{ $system['scan_date'] ?? '-' }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="ml-4 text-right">
                            <div class="text-xs text-gray-600 mb-1">Pass Rate</div>
                            <div class="text-2xl font-bold text-{{ $color }}-600">
                                {{ number_format($passRate, 1) }}%
                            </div>
                            <div class="mt-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($system['grade'] === 'F' || $system['grade'] === 'N/A')
                                        bg-red-100 text-red-800
                                    @elseif($system['grade'] === 'D' || $system['grade'] === 'D-')
                                        bg-orange-100 text-orange-800
                                    @elseif($system['grade'] === 'C' || $system['grade'] === 'C-')
                                        bg-yellow-100 text-yellow-800
                                    @else
                                        bg-green-100 text-green-800
                                    @endif
                                ">
                                    Grade: {{ $system['grade'] ?? 'N/A' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div class="mt-3">
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-{{ $color }}-500 h-2 rounded-full transition-all duration-300" style="width: {{ $passRate }}%"></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
