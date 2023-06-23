<tr wire:poll>
    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8">
        {{ $bodyShopAudit->audit_date->format('M d, Y') }}
    </td>
    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 flex justify-end text-sm font-medium sm:pr-6 lg:pr-8 space-x-5">
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
                @if(!$bodyShopAudit->pdf_path)
                    <a
                        href="{{ route('dealer.stores.audits.body-shop.show', [$store, $bodyShopAudit]) }}"
                        class="inline-flex items-center gap-x-1.5 rounded-md bg-white px-2.5 py-1.5 text-sm shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                    >
                        Edit
                    </a>
                @endif
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
