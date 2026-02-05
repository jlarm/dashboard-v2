<div class="grid grid-cols-2 lg:grid-cols-6 gap-4">
    <!-- Issues -->
    <div class="bg-white border border-gray-200 rounded-lg p-4">
        <div class="text-sm text-gray-600 mb-1">Issues</div>
        <div class="text-3xl font-bold text-gray-900">{{ $details['vulnerabilities'] ?? '-' }}</div>
    </div>

    <!-- Critical -->
    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
        <div class="text-sm text-gray-600 mb-1">Critical</div>
        <div class="text-3xl font-bold text-red-600">{{ $details['critical_vulnerabilities'] ?? '-' }}</div>
    </div>

    <!-- High -->
    <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
        <div class="text-sm text-gray-600 mb-1">High</div>
        <div class="text-3xl font-bold text-orange-600">{{ $details['high_vulnerabilities'] ?? '-' }}</div>
    </div>

    <!-- Medium -->
    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
        <div class="text-sm text-gray-600 mb-1">Medium</div>
        <div class="text-3xl font-bold text-yellow-600">{{ $details['medium_vulnerabilities'] ?? '-' }}</div>
    </div>

    <!-- Low -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="text-sm text-gray-600 mb-1">Low</div>
        <div class="text-3xl font-bold text-gray-900">{{ $details['low_vulnerabilities'] ?? '-' }}</div>
    </div>

    <!-- Grade -->
    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
        <div class="flex items-center gap-1 text-sm text-gray-600 mb-1">
            Grade
        </div>
        <div class="text-3xl font-bold text-gray-900">{{ $details['grade_alpha'] ?? '-' }}</div>
    </div>
</div>
