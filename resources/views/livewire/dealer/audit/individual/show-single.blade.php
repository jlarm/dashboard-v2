<tr>
    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8">{{ $audit->customer_number }}</td>
    <td class="whitespace-nowrap px-3 py-4 text-sm font-medium text-gray-900">{{ $audit->customer_name }}</td>
    <td class="whitespace-nowrap px-3 py-4 text-sm font-medium text-gray-900">{{ $audit->manager->name ?? '' }}</td>
    <td class="whitespace-nowrap px-3 py-4 text-sm font-medium text-gray-900">
        @if($rating >= 90)
            <span
                class="inline-flex items-center rounded-full bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">A</span>
        @elseif($rating >= 80)
            <span
                class="inline-flex items-center rounded-full bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">B</span>
        @elseif($rating >= 70)
            <span
                class="inline-flex items-center rounded-full bg-yellow-50 px-2 py-1 text-xs font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20">C</span>
        @elseif($rating >= 60)
            <span
                class="inline-flex items-center rounded-full bg-orange-50 px-2 py-1 text-xs font-medium text-orange-700 ring-1 ring-inset ring-orange-600/10">D</span>
        @else
            <span
                class="inline-flex items-center rounded-full bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">F</span>
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
