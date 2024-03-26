<div>
<x-table.row>
    <x-table.cell class="pl-4 pr-3">
        <div class="text-sm font-medium text-gray-900">{{ $campaign['name'] }}</div>
    </x-table.cell>
    <x-table.cell class="px-2">
        <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($campaign['created_date'])->format('F d, Y') }}</div>
    </x-table.cell>
    <x-table.cell class="px-2">
        <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset
            @if($campaign['status'] === 'Email Sent')
                bg-gray-50 text-gray-600 ring-gray-500/10
            @elseif($campaign['status'] === 'Emails Sent')
                bg-gray-50 text-gray-600 ring-gray-500/10
            @elseif($campaign['status'] === 'In progress')
                bg-blue-50 text-blue-700 ring-blue-700/10
            @elseif($campaign['status'] === 'Completed')
                bg-green-50 text-green-700 ring-green-600/20
            @elseif($campaign['status'] === 'Queued')
                bg-yellow-50 text-yellow-800 ring-yellow-600/20
            @endif
        ">
            {{ $campaign['status'] }}
        </span>
    </x-table.cell>
    <x-table.cell class="pl-3 pr-4 sm:pr-0">
        @if($campaign['status'] != 'Queued')
            <a href="{{ route('dealer.phishing.show', $campaign) }}" class="text-arm-blue-600 hover:text-arm-blue-900">View</a>
        @endif
    </x-table.cell>
</x-table.row>
</div>
