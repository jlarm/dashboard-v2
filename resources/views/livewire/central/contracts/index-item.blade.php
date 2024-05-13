<x-table.row>
    <x-table.cell>{{ $contract->id }}</x-table.cell>
    <x-table.cell>{{ $contract->dealer_name }}</x-table.cell>
    <x-table.cell>
        @if($contract->dealer_signature)
            <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Approved</span>
        @else
            <span class="inline-flex items-center rounded-md bg-yellow-50 px-2 py-1 text-xs font-medium text-yellow-700 ring-1 ring-inset ring-yellow-600/20">In Progress</span>
        @endif
    </x-table.cell>
    <x-table.cell class="flex justify-end gap-5">
        <a href="{{ route('contracts.edit', $contract) }}">View</a>
        @if(!$contract->dealer_signature)
           <livewire:central.contracts.delete :contract="$contract" />
        @endif
    </x-table.cell>
</x-table.row>
