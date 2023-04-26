<tr>
    <td class="px-4 py-4 text-sm text-gray-700">
        {{ $audit->created_at->format('M d, Y') }}
    </td>
    <td class="px-4 py-4">
        @if($audit->draft)
            <span
                class="inline-flex items-center rounded-md bg-yellow-50 px-2 py-1 text-xs font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20">Draft</span>
        @else
            <span
                class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Completed</span>
        @endif
    </td>
    <td class="text-right px-4 py-4">
        <div class="flex justify-end items-center space-x-3">
            @if(!$audit->draft)
                <button type="button"
                        class="inline-flex items-center gap-x-1.5 rounded-md bg-arm-blue-600 px-2.5 py-1.5 text-sm text-white shadow-sm hover:bg-arm-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-arm-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="-ml-0.5 h-5 w-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M9 12.75l3 3m0 0l3-3m-3 3v-7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>

                    Download
                </button>
            @endif
            <a href="{{ route('dealer.audit.osha.show', $audit) }}" type="button"
               class="inline-flex items-center gap-x-1.5 rounded-md bg-white px-2.5 py-1.5 text-sm shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                Edit
            </a>
            <button
                class="text-red-500 text-sm"
                wire:click="$emit('modal.open', 'dealer.audit.osha.delete',  @js(['oshaAudit' => $audit->id]))"
            >
                Delete
            </button>
        </div>
    </td>
</tr>
