<div>
    <div class="mb-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Sensitive Data Exposure</h3>
                <p class="text-sm text-gray-600">Identifying sensitive data locations and risks</p>
            </div>
            <div class="text-right">
                <div class="text-sm text-gray-600 mb-1">Data Scan Grade</div>
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

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Top Data Categories -->
        <div class="border border-gray-200 rounded-lg p-4">
            <h4 class="text-sm font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
                Top Sensitive Data Types
            </h4>
            @if(empty($topCategories))
                <div class="text-center py-6 text-gray-500">
                    <p class="text-sm">No data categories found</p>
                </div>
            @else
                <div class="space-y-3">
                    @foreach($topCategories as $category)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="flex-shrink-0 h-8 w-8 flex items-center justify-center rounded-full bg-indigo-100">
                                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-900">{{ $category['name'] ?? 'Unknown' }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-semibold text-gray-700">{{ $category['times_searched'] ?? 0 }}</span>
                                <span class="text-xs text-gray-500">scans</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Most Sensitive Endpoints -->
        <div class="border border-gray-200 rounded-lg p-4">
            <h4 class="text-sm font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                Most Sensitive Endpoints
            </h4>
            @if(empty($mostSensitiveEndpoints))
                <div class="text-center py-6 text-gray-500">
                    <p class="text-sm">No sensitive endpoints found</p>
                </div>
            @else
                <div class="space-y-3">
                    @foreach($mostSensitiveEndpoints as $endpoint)
                        @php
                            $riskGrade = $endpoint['risk_grade'] ?? 'F';
                            $color = $this->getRiskColor($riskGrade);
                        @endphp
                        <div class="p-3 border border-gray-200 rounded-lg hover:shadow-sm transition-shadow">
                            <div class="flex items-start justify-between mb-2">
                                <div class="flex-1">
                                    <div class="text-sm font-medium text-gray-900">{{ $endpoint['name'] ?? 'Unknown' }}</div>
                                    <div class="text-xs text-gray-500">{{ $endpoint['ip_address'] ?? '-' }}</div>
                                </div>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold bg-{{ $color }}-100 text-{{ $color }}-800">
                                    {{ $riskGrade }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between text-xs">
                                <div>
                                    <span class="text-gray-600">Sensitive Items:</span>
                                    <span class="font-semibold text-red-600 ml-1">{{ number_format($endpoint['total_sensitive_items'] ?? 0) }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Risk:</span>
                                    <span class="font-semibold text-{{ $color }}-600 ml-1">{{ $endpoint['percent_sensitive'] ?? 0 }}%</span>
                                </div>
                            </div>
                            @if(isset($endpoint['last_scanned']))
                                <div class="text-xs text-gray-500 mt-2">
                                    Last scanned: {{ $endpoint['last_scanned'] }}
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
