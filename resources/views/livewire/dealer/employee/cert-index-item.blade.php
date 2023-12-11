<li class="flex items-center justify-between gap-x-6">
    <div class="flex min-w-0 gap-x-4">
        <div class="min-w-0 flex-auto">
            <p class="text-sm font-semibold text-gray-900">{{ $cert->course_name }} Certificate</p>
            <p class="mt-1 truncate text-xs leading-5 text-gray-500">{{ $cert->created_at->format('F d, Y') }}</p>
        </div>
    </div>
    <a href="{{ $url }}" target="_blank" class="text-arm-blue-600 hover:text-arm-blue-900 text-sm">Download</a>
</li>
