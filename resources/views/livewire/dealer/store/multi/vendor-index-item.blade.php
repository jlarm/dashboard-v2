<tr>
    <td class="px-4 py-4">
        <div class="flex space-x-4 w-max">
            <div class="flex-1">
                <span class="text-sm font-semibold text-gray-800">{{ $vendor->name }}</span>
            </div>
        </div>
    </td>
    <td class="px-4 py-4 text-sm text-gray-700">
        {{ $vendor->contact_name ?? '-' }}
    </td>
    <td class="px-4 py-4 text-sm text-gray-700">
        <div><a href="mailto:{{ $vendor->contact_email }}">{{ $vendor->contact_email }}</a></div>
    </td>
    <td class="px-4 py-4 text-sm text-gray-700">
        {{ $vendor->store->name ?? tenant('name') }}
    </td>
    <td class="px-4 py-4 text-sm text-gray-700">
        @if(\Carbon\Carbon::now() > $vendor->updated_at->addYear() || !$vendor->q1a )
            <span class="inline-flex items-center rounded bg-red-100 px-2 py-0.5 text-xs font-medium text-red-800">Outdated</span>
        @else
            <span class="inline-flex items-center rounded bg-green-100 px-2 py-0.5 text-xs font-medium text-green-800">Current</span>
        @endif
    </td>
    <td class="px-4 py-4 text-right">
        <div class="flex space-x-3 justify-end items-end">
            <a href="#" class="text-sm">
                Download
            </a>
            @can('create-stores')
                <a href="#" class="text-sm">
                    Send
                </a>
            @endcan
        </div>
    </td>
</tr>
