<div>
    @if ($scanDates)
        <span class="text-xs text-gray-500">Last Scan: {{ \Carbon\Carbon::parse($scanDates->last_scan)->format('m/d/Y') }} | Next Scan: {{ \Carbon\Carbon::parse($scanDates->next_scan)->format('m/d/Y') }}</span>
    @endif
</div>
