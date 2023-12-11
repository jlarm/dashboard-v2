<tr>
    <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm text-gray-500 sm:pl-0">{{ $cert->course_name }}</td>
    <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-500">{{ $cert->created_at->format('F d, Y') }}</td>
    <td class="relative whitespace-nowrap py-2 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
        <a href="{{ $url }}" target="_blank" class="text-arm-blue-600 hover:text-arm-blue-900">Download</a>
    </td>
</tr>
