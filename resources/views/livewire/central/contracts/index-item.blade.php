<x-table.row>
    @can('delete-users')
    <x-table.cell>{{ $contract->id }}</x-table.cell>
    @endcan
    <x-table.cell>
        {{ $contract->dealer_name }}
        @can('delete-users')
        <div class="font-mono text-xs leading-6 text-gray-400">{{ $contract->uuid }}</div>
        @endcan
    </x-table.cell>
    <x-table.cell>
        @if($this->progress() == 1)
            <span class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-700 ring-1 ring-inset ring-gray-600/20">Contract Created</span>
        @elseif($this->progress() == 2)
            <span class="inline-flex items-center rounded-md bg-yellow-50 px-2 py-1 text-xs font-medium text-yellow-700 ring-1 ring-inset ring-yellow-600/20">Contract Sent for Review</span>
        @elseif($this->progress() == 3)
            <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-600/20">Contract Signed by Dealer</span>
        @elseif($this->progress() == 4)
            <span class="inline-flex items-center rounded-md bg-purple-50 px-2 py-1 text-xs font-medium text-purple-700 ring-1 ring-inset ring-purple-600/20">Contract Signed by ARMP</span>
        @elseif($this->progress() == 5)
            <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Contract Completed</span>
        @endif
    </x-table.cell>
    <x-table.cell class="flex justify-end gap-5">
        <a href="{{ route('contracts.edit', $contract) }}">View</a>
        @if(!$contract->dealer_signature)
           <livewire:central.contracts.delete :contract="$contract" />
        @endif
    </x-table.cell>
</x-table.row>
