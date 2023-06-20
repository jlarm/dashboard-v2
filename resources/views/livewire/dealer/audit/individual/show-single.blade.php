<tr>
    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8">{{ $audit->customer_number }}</td>
    <td class="whitespace-nowrap px-3 py-4 text-sm font-medium text-gray-900">{{ $audit->customer_name }}
    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
        @if($audit->draft)
            <span
                class="inline-flex items-center rounded-md bg-yellow-50 px-2 py-1 text-xs font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20">Draft</span>
        @else
            <span
                class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Completed</span>
        @endif
    </td>
    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6 lg:pr-8">
        <div class="space-x-5">
            <a
                href="{{ (!tenant('locations') ? route('dealer.audit.individual.edit', $audit) : route('dealer.stores.audits.individual.edit', [$store, $audit])) }}"
                class="inline-flex items-center gap-x-1.5 rounded-md bg-white px-2.5 py-1.5 text-sm shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
            >
                Edit
            </a>
            <button
                class="text-red-500 text-sm"
                wire:click="$emit('modal.open', 'dealer.audit.individual.delete',  @js(['individualAudit' => $audit->id]))"
            >
                Delete
            </button>
        </div>
    </td>
</tr>
