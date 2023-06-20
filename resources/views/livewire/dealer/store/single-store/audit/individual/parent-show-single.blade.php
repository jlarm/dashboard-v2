<tr>
    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8">{{ $individualAudit->customer_number }}
    <td class="whitespace-nowrap px-3 py-4 text-sm font-medium text-gray-900">{{ $individualAudit->customer_name }}
    </td>
    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
        @if($individualAudit->draft)
            <span
                class="inline-flex items-center rounded-md bg-yellow-50 px-2 py-1 text-xs font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20">Draft</span>
        @else
            <span
                class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Completed</span>
        @endif
    </td>
    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6 lg:pr-8">
        <div class="space-x-5">
            <a href="{{ route('dealer.stores.audits.individual.edit', [$store, $individualAudit]) }}"
               class="inline-flex items-center gap-x-1.5 rounded-md bg-white px-2.5 py-1.5 text-sm shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
            >
                Edit
            </a>
            @if(!$children)
                <a
                    class="text-red-500 text-sm"
                    href="#"
                    wire:click="delete"
                >
                    Delete
                </a>
            @endif
        </div>
    </td>
</tr>
