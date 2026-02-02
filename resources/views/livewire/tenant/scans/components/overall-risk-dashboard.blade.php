<div>
    <div class="mb-4">
        <h2 class="text-lg font-semibold text-gray-900">Overall Risk Assessment</h2>
        <p class="text-sm text-gray-600">Current security posture across all scan types</p>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <!-- Overall Risk -->
        <div class="bg-white border border-gray-200 rounded-lg p-4">
            <div class="flex items-center justify-between mb-2">
                <div class="text-sm font-medium text-gray-700">Overall Risk</div>
                @php
                    $trend = $this->getGradeTrend($riskData['current_or_grade'] ?? 'F', $riskData['previous_or_grade'] ?? 'F');
                @endphp
                @if($trend === 'improved')
                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                @elseif($trend === 'declined')
                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/>
                    </svg>
                @else
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14"/>
                    </svg>
                @endif
            </div>
            <div class="text-3xl font-bold text-gray-900">{{ $riskData['current_or_grade'] ?? '-' }}</div>
            <div class="text-xs text-gray-600 mt-1">Previous: {{ $riskData['previous_or_grade'] ?? '-' }}</div>
        </div>

        <!-- Vulnerabilities -->
        <div class="bg-white border border-gray-200 rounded-lg p-4">
            <div class="flex items-center justify-between mb-2">
                <div class="text-sm font-medium text-gray-700">Vulnerabilities</div>
                @php
                    $trend = $this->getGradeTrend($riskData['current_vn_grade'] ?? 'F', $riskData['previous_vn_grade'] ?? 'F');
                @endphp
                @if($trend === 'improved')
                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                @elseif($trend === 'declined')
                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/>
                    </svg>
                @else
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14"/>
                    </svg>
                @endif
            </div>
            <div class="text-3xl font-bold text-gray-900">{{ $riskData['current_vn_grade'] ?? '-' }}</div>
            <div class="text-xs text-gray-600 mt-1">Previous: {{ $riskData['previous_vn_grade'] ?? '-' }}</div>
        </div>

        <!-- Data Scans -->
{{--        <div class="bg-white border border-gray-200 rounded-lg p-4">--}}
{{--            <div class="flex items-center justify-between mb-2">--}}
{{--                <div class="text-sm font-medium text-gray-700">Data Scans</div>--}}
{{--                @php--}}
{{--                    $trend = $this->getGradeTrend($riskData['current_ds_grade'] ?? 'F', $riskData['previous_ds_grade'] ?? 'F');--}}
{{--                @endphp--}}
{{--                @if($trend === 'improved')--}}
{{--                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">--}}
{{--                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>--}}
{{--                    </svg>--}}
{{--                @elseif($trend === 'declined')--}}
{{--                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">--}}
{{--                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/>--}}
{{--                    </svg>--}}
{{--                @else--}}
{{--                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">--}}
{{--                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14"/>--}}
{{--                    </svg>--}}
{{--                @endif--}}
{{--            </div>--}}
{{--            <div class="text-3xl font-bold text-gray-900">{{ $riskData['current_ds_grade'] ?? '-' }}</div>--}}
{{--            <div class="text-xs text-gray-600 mt-1">Previous: {{ $riskData['previous_ds_grade'] ?? '-' }}</div>--}}
{{--        </div>--}}

        <!-- Baseline Configs -->
{{--        <div class="bg-white border border-gray-200 rounded-lg p-4">--}}
{{--            <div class="flex items-center justify-between mb-2">--}}
{{--                <div class="text-sm font-medium text-gray-700">Baseline</div>--}}
{{--                @php--}}
{{--                    $trend = $this->getGradeTrend($riskData['current_sb_grade'] ?? 'F', $riskData['previous_sb_grade'] ?? 'F');--}}
{{--                @endphp--}}
{{--                @if($trend === 'improved')--}}
{{--                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">--}}
{{--                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>--}}
{{--                    </svg>--}}
{{--                @elseif($trend === 'declined')--}}
{{--                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">--}}
{{--                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/>--}}
{{--                    </svg>--}}
{{--                @else--}}
{{--                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">--}}
{{--                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14"/>--}}
{{--                    </svg>--}}
{{--                @endif--}}
{{--            </div>--}}
{{--            <div class="text-3xl font-bold text-gray-900">{{ $riskData['current_sb_grade'] ?? '-' }}</div>--}}
{{--            <div class="text-xs text-gray-600 mt-1">Previous: {{ $riskData['previous_sb_grade'] ?? '-' }}</div>--}}
{{--        </div>--}}

        <!-- Compliance -->
{{--        <div class="bg-white border border-gray-200 rounded-lg p-4">--}}
{{--            <div class="flex items-center justify-between mb-2">--}}
{{--                <div class="text-sm font-medium text-gray-700">Compliance</div>--}}
{{--                @php--}}
{{--                    $trend = $this->getGradeTrend($riskData['current_cmpl_grade'] ?? 'F', $riskData['previous_cmpl_grade'] ?? 'F');--}}
{{--                @endphp--}}
{{--                @if($trend === 'improved')--}}
{{--                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">--}}
{{--                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>--}}
{{--                    </svg>--}}
{{--                @elseif($trend === 'declined')--}}
{{--                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">--}}
{{--                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/>--}}
{{--                    </svg>--}}
{{--                @else--}}
{{--                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">--}}
{{--                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14"/>--}}
{{--                    </svg>--}}
{{--                @endif--}}
{{--            </div>--}}
{{--            <div class="text-3xl font-bold text-gray-900">{{ $riskData['current_cmpl_grade'] ?? '-' }}</div>--}}
{{--            <div class="text-xs text-gray-600 mt-1">Previous: {{ $riskData['previous_cmpl_grade'] ?? '-' }}</div>--}}
{{--        </div>--}}
    </div>
</div>
