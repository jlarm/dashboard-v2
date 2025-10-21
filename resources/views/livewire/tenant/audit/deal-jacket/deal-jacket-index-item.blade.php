<x-table.row>
    <x-table.cell>
        {{ $dealJacket->customer_name }}
        <span class="text-xs block">{{ $dealJacket->customer_deal_number }}</span>
    </x-table.cell>
    <x-table.cell>{{ $dealJacket->audit_date->format('F d, Y') }}</x-table.cell>
    <x-table.cell>{{ $dealJacket->total_passed }}</x-table.cell>
    <x-table.cell>{{ $dealJacket->total_failed }}</x-table.cell>
    <x-table.cell>{{ $dealJacket->total_high_risk }}</x-table.cell>
    <x-table.cell>
        <span
            @class([
                "inline-flex items-center py-0.5 px-1.5 rounded-full text-xs font-medium",
                "bg-green-100 text-green-800" => $this->grade() === 'A',
                "bg-blue-100 text-blue-800" => $this->grade() === 'B',
                "bg-gray-100 text-gray-800" => $this->grade() === 'C',
                "bg-yellow-100 text-yellow-800" => $this->grade() === 'D',
                "bg-red-100 text-red-800" => $this->grade() === 'F',
            ])
        >
            {{ $this->grade() }}
        </span>
    </x-table.cell>
    <x-table.cell class="flex justify-end">
        <x-menu-dropdown align="right" width="48">
            <x-slot:trigger>
                <x-button variant="ghost" size="sm">
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                </x-button>
            </x-slot:trigger>
            <x-slot:content>
                <x-menu-dropdown-item
                    :href="tenant('locations')
                        ? route('dealer.stores.audits.deal-jackets.single', [$store, 'dealJacketGroup' => $dealJacketGroup, 'dealJacket' => $dealJacket,])
                        : route('dealer.audit.deal-jackets.single', ['dealJacketGroup' => $dealJacketGroup, 'dealJacket' => $dealJacket,])
                    "
                >
                    <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>
                    View
                </x-menu-dropdown-item>
                @hasanyrole('super-admin|Consultant')
                <x-menu-dropdown-item
                    :href="tenant('locations') ? route('dealer.stores.audits.deal-jackets.edit', [$store, 'dealJacketGroup' => $dealJacketGroup,'dealJacket' => $dealJacket,]) : route('dealer.audit.deal-jackets.edit', ['dealJacketGroup' => $dealJacketGroup,'dealJacket' => $dealJacket,])"
                >
                    <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/><path d="m15 5 4 4"/></svg>
                    Edit
                </x-menu-dropdown-item>
                <button
                    type="button"
                    @click="open = false"
                    wire:click="$emit('modal.open', 'tenant.audit.deal-jacket.deal-jacket-delete-modal', @js(['dealJacket' => $dealJacket->id]))"
                    class="w-full flex items-center gap-x-3 py-1.5 px-2 rounded-lg text-[13px] text-red-600 hover:bg-red-100 disabled:opacity-50 focus:outline-hidden focus:bg-red-100 disabled:pointer-events-none"
                >
                    <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path><line x1="10" x2="10" y1="11" y2="17"></line><line x1="14" x2="14" y1="11" y2="17"></line></svg>
                    Delete
                </button>
                @endhasanyrole
            </x-slot:content>
        </x-menu-dropdown>
    </x-table.cell>
</x-table.row>
