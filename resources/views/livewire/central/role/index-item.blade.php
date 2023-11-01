<tr>
    <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm text-gray-500 sm:pl-0">{{ $role->name }}</td>
    <td class="whitespace-wrap py-2 pl-4 pr-3 text-sm text-gray-500 sm:pl-0 space-y-3">
        @foreach($role->permissions as $permission)
            <span
                class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">
                {{ $permission->name }}
            </span>
        @endforeach
    </td>
    <td class="relative whitespace-nowrap py-2 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
        <a href="{{ route('role.edit', $role) }}" class="text-arm-blue-600 hover:text-arm-blue-900">Edit<span
                class="sr-only">, {{ $role->name }}</span></a>
    </td>
</tr>
