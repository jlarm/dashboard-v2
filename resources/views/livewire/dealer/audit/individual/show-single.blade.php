<tr>
    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8">{{ $audit->customer_number }}</td>
    <td class="whitespace-nowrap px-3 py-4 text-sm font-medium text-gray-900">{{ $audit->customer_name }}
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
