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
    <td class="px-4 py-4 text-right">
        <a href="#" class="text-sm">View</a>
    </td>
</tr>
