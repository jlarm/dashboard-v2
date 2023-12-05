<tr>
    <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm text-gray-500 sm:pl-0">
        {{ $oshaAudit->audit_date->format('M d, Y') }}
    </td>
    <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-900">
        @if($oshaAudit->rating)
            @if($oshaAudit->rating >= 90)
                <span
                    class="inline-flex items-center rounded-full bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">A</span>
            @elseif($oshaAudit->rating >= 80)
                <span
                    class="inline-flex items-center rounded-full bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">B</span>
            @elseif($oshaAudit->rating >= 70)
                <span
                    class="inline-flex items-center rounded-full bg-yellow-50 px-2 py-1 text-xs font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20">C</span>
            @elseif($oshaAudit->rating >= 60)
                <span
                    class="inline-flex items-center rounded-full bg-orange-50 px-2 py-1 text-xs font-medium text-orange-700 ring-1 ring-inset ring-orange-600/10">D</span>
            @else
                <span
                    class="inline-flex items-center rounded-full bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">F</span>
            @endif
        @else
            -
        @endif
    </td>
    <td class="relative whitespace-nowrap py-4 pl-3 flex justify-end text-sm font-medium">
        <div class="flex items-center space-x-5">
                        @can('create-audits')
            @if(!$oshaAudit->pdf_path)
                <livewire:dealer.audit.osha.generate :oshaAudit="$oshaAudit"/>
            @endif
                        @endcan
            @if($oshaAudit->pdf_path)
                <livewire:dealer.audit.osha.download :oshaAudit="$oshaAudit"/>
            @endif
                        @can('create-audits')
            @if(!$oshaAudit->pdf_path)
                <a
                    href="{{ route('dealer.stores.audits.osha.show', [$store, $oshaAudit]) }}"
                    class="inline-flex items-center gap-x-1.5 rounded-md bg-white px-2.5 py-1.5 text-sm shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                >
                    Edit
                </a>
            @endif
            <button
                class="text-red-500 text-sm"
                wire:click="$emit('modal.open', 'dealer.audit.osha.delete',  @js(['oshaAudit' => $oshaAudit->id]))"
            >
                Delete
            </button>
          @endcan
        </div>
    </td>
</tr>
