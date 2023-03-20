<tr>
    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ $role->name }}</td>
    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6 space-x-5">
        <a
            href="{{ route('role.edit', $role) }}"
        >
            Edit
        </a>
    </td>
</tr>
