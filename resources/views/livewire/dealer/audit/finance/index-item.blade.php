<tr wire:poll>
    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8">
        {{ $financeAudit->audit_date->format('M d, Y') }}
    </td>
    @can('create-audits')
        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
            @if($financeAudit->draft)
                <span
                    class="inline-flex items-center rounded-md bg-yellow-50 px-2 py-1 text-xs font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20">Draft</span>
            @else
                <span
                    class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Completed</span>
            @endif
        </td>
    @endcan
    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 flex justify-end text-sm font-medium sm:pr-6 lg:pr-8">
        <div class="flex items-center space-x-5">
            @can('create-audits')
                @if(!$financeAudit->draft && !$financeAudit->pdf_path)
                    <livewire:dealer.audit.finance.generate :financeAudit="$financeAudit"/>
                @endif
            @endcan
            @if($financeAudit->pdf_path)
                <livewire:dealer.audit.finance.download :financeAudit="$financeAudit"/>
            @endif
            @can('create-audits')
                {{--                @if(!$financeAudit->pdf_path)--}}
                <a
                    href="{{ route('dealer.audit.finance.show', $financeAudit) }}"
                    class="inline-flex items-center gap-x-1.5 rounded-md bg-white px-2.5 py-1.5 text-sm shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                >
                    Edit
                </a>
                {{--                @endif--}}
                <button
                    class="text-red-500 text-sm"
                    wire:click="$emit('modal.open', 'dealer.audit.finance.delete',  @js(['financeAudit' => $financeAudit->id]))"
                >
                    Delete
                </button>
            @endcan
        </div>
    </td>
</tr>
