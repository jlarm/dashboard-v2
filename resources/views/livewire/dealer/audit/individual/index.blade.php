<div>
    <x-table>
        <x-slot name="head">
            <x-table.row>
                <x-table.heading>Date</x-table.heading>
                <x-table.heading>Rating</x-table.heading>
                <x-table.heading></x-table.heading>
            </x-table.row>
        </x-slot>
        <x-slot name="body">
            @forelse($audits as $individualAudit)
                <livewire:dealer.audit.individual.index-item :store="$store" :individualAudit="$individualAudit"/>
            @empty
                <tr>
                    <td colspan="7"
                        class="px-4 py-4 text-center text-xl text-arm-blue-500 font-medium sm:pr-6 space-x-3">
                        <div class="text-center">
                            <h3 class="mt-2 text-sm font-semibold text-gray-900">No audits</h3>
                        </div>
                    </td>
                </tr>
            @endforelse
        </x-slot>
    </x-table>
</div>
