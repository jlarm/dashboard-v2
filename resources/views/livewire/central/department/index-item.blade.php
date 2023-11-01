<tr>
    <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm text-gray-500 sm:pl-0">{{ $department->name }}</td>
    <td class="relative whitespace-nowrap py-2 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
        <a href="{{ route('department.edit', $department) }}"
           class="text-arm-blue-600 hover:text-arm-blue-900">Edit<span
                class="sr-only">, {{ $department->name }}</span></a>
    </td>
</tr>
