<tr>
    <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm text-gray-500 sm:pl-0">{{ $oshaViolationStatements->statement }}</td>
    <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm text-gray-500 sm:pl-0">{{ $oshaViolationStatements->weight }}</td>
    <td class="relative whitespace-nowrap py-2 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
        @role('super-admin')
        <div class="flex justify-end gap-2">
            <a href="{{ route('osha-violations.edit', $oshaViolationStatements) }}" class="text-arm-blue-600 hover:text-arm-blue-900">Edit<span class="sr-only">, {{ $oshaViolationStatements->violation }}</span></a>
        </div>
        @endrole
    </td>
</tr>
