<x-table.row>
    <x-table.cell class="w-64">
        <div class="flex items-center gap-x-3">
            {{ $dealJacketGroup->created_at->format('M d, Y') }}
            @if(!$dealJacketGroup->completed)
                <div>
                  <span class="py-1 px-1.5 inline-flex items-center gap-x-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-lg">
                    In Progress
                  </span>
                </div>
            @endif
        </div>
    </x-table.cell>
    <x-table.cell class="w-32">{{ $dealJacketGroup->deal_jackets_count }}</x-table.cell>
    <x-table.cell class="w-24">{{ $dealJacketGroup->total_passed ?? '-' }}</x-table.cell>
    <x-table.cell class="w-24">{{ $dealJacketGroup->total_failed ?? '-' }}</x-table.cell>
    <x-table.cell class="w-24">{{ $dealJacketGroup->total_high_risk ?? '-' }}</x-table.cell>
    <x-table.cell class="w-48">
        @if($dealJacketGroup->completed && $dealJacketGroup->average_percentage !== null)
            <div class="flex items-center gap-2">
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
            </div>
        @else
            -
        @endif
    </x-table.cell>
    <x-table.cell class="w-16 flex justify-end !pr-0">
        <x-menu-dropdown align="right" width="48">
            <x-slot:trigger>
                <x-button variant="ghost" size="sm">
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                </x-button>
            </x-slot:trigger>
            <x-slot:content>
                <x-menu-dropdown-item href="{{ route('dealer.audit.deal-jackets.show', $dealJacketGroup->uuid) }}">
                    <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"></path><path d="m15 5 4 4"></path></svg>
                    View
                </x-menu-dropdown-item>
                @if(!$dealJacketGroup->completed && $dealJacketGroup->deal_jackets_count)
                    @hasanyrole('super-admin|Consultant')
                    <button
                        type="button"
                        @click="open = false"
                        wire:click="$emit('modal.open', 'tenant.audit.deal-jacket.components.mark-complete-modal', @js(['dealJacketGroupId' => $dealJacketGroup->id]))"
                        class="w-full flex items-center gap-x-3 py-1.5 px-2 rounded-lg text-[13px] text-green-700 hover:bg-green-100 disabled:opacity-50 focus:outline-hidden focus:bg-green-100 disabled:pointer-events-none"
                    >
                        <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-icon lucide-check"><path d="M20 6 9 17l-5-5"/></svg>
                        Mark as Complete
                    </button>
                    @endhasanyrole
                @else
                <button
                    type="button"
                    @click="open = false"
                    wire:click="$emit('modal.open', 'tenant.audit.deal-jacket.generate-report', @js(['dealJacketGroupId' => $dealJacketGroup->id]))"
                    class="w-full flex items-center gap-x-3 py-1.5 px-2 rounded-lg text-[13px] text-gray-800 hover:bg-gray-100 disabled:opacity-50 focus:outline-hidden focus:bg-gray-100 disabled:pointer-events-none"
                >
                    <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" x2="15.42" y1="13.51" y2="17.49"></line><line x1="15.41" x2="8.59" y1="6.51" y2="10.49"></line></svg>
                    Generate Report
                </button>
                @endif
                @hasanyrole('super-admin|Consultant')
                <div class="my-1 border-t border-gray-200"></div>
                <button
                    type="button"
                    @click="open = false"
                    wire:click="$emit('modal.open', 'tenant.audit.deal-jacket.deal-jacket-group-delete-modal', @js(['dealJacketGroup' => $dealJacketGroup->id]))"
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
