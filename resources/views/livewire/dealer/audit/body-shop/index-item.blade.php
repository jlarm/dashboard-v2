<tr wire:poll>
    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8">
        {{ $bodyShopAudit->audit_date->format('M d, Y') }}
    </td>
    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8">
        @if($bodyShopAudit->rating)
            @if($bodyShopAudit->rating >= 90)
                <span
                    class="inline-flex items-center rounded-full bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">A</span>
            @elseif($bodyShopAudit->rating >= 80)
                <span
                    class="inline-flex items-center rounded-full bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">B</span>
            @elseif($bodyShopAudit->rating >= 70)
                <span
                    class="inline-flex items-center rounded-full bg-yellow-50 px-2 py-1 text-xs font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20">C</span>
            @elseif($bodyShopAudit->rating >= 60)
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
    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 flex justify-end text-sm font-medium sm:pr-6 lg:pr-8">
        <div class="flex items-center space-x-5">
            @can('create-audits')
                @if(!$bodyShopAudit->pdf_path)
                    <livewire:dealer.audit.body-shop.generate :bodyShopAudit="$bodyShopAudit"/>
                @endif
            @endcan
            @if($bodyShopAudit->pdf_path)
                <livewire:dealer.audit.body-shop.download :bodyShopAudit="$bodyShopAudit"/>
            @endif
            @can('create-audits')
                {{--                @if(!$bodyShopAudit->pdf_path)--}}
                <a
                    href="{{ route('dealer.audit.body-shop.show', $bodyShopAudit) }}"
                    class="inline-flex items-center gap-x-1.5 rounded-md bg-white px-2.5 py-1.5 text-sm shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                >
                    Edit
                </a>
                {{--                @endif--}}
                <button
                    class="text-red-500 text-sm"
                    wire:click="$emit('modal.open', 'dealer.audit.body-shop.delete',  @js(['bodyShopAudit' => $bodyShopAudit->id]))"
                >
                    Delete
                </button>
            @endcan
        </div>
    </td>
</tr>
