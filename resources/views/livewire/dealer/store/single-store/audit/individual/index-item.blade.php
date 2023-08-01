<tr wire:poll>
    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8">
        {{ $individualAudit->audit_date->format('M d, Y') }}
    </td>
    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 flex justify-end text-sm font-medium sm:pr-6 lg:pr-8 space-x-5">
        <a
            href="{{ route('dealer.stores.audits.individual.show', [$store, $individualAudit]) }}"
            class="inline-flex items-center gap-x-1.5 rounded-md bg-white px-2.5 py-1.5 text-sm shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
        >
            View
        </a>
    </td>
</tr>
