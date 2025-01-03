<x-table.row>
    <x-table.cell>{{ $individualAudit->customer_number }}</x-table.cell>
    <x-table.cell>{{ $individualAudit->customer_name }}</x-table.cell>
    <x-table.cell>{{ $individualAudit->manager->name ?? '' }}</x-table.cell>
    <x-table.cell>
        @if($individualAudit->rating)
            @if($individualAudit->rating >= 90)
                <span
                    class="inline-flex items-center rounded-full bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">A</span>
            @elseif($individualAudit->rating >= 80)
                <span
                    class="inline-flex items-center rounded-full bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">B</span>
            @elseif($individualAudit->rating >= 70)
                <span
                    class="inline-flex items-center rounded-full bg-yellow-50 px-2 py-1 text-xs font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20">C</span>
            @elseif($individualAudit->rating >= 60)
                <span
                    class="inline-flex items-center rounded-full bg-orange-50 px-2 py-1 text-xs font-medium text-orange-700 ring-1 ring-inset ring-orange-600/10">D</span>
            @else
                <span
                    class="inline-flex items-center rounded-full bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">F</span>
            @endif
        @else
            -
        @endif
    </x-table.cell>
    <x-table.cell>
        <div class="flex justify-end items-center gap-3">
            <a href="{{ route('dealer.stores.audits.individual.edit', [$store, $individualAudit]) }}"
               class="inline-flex items-center gap-x-1.5 rounded-md bg-white px-2.5 py-1.5 text-sm shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
            >
                Edit
            </a>
            @if(!$children)
                <a
                    class="text-red-500 text-sm"
                    href="#"
                    wire:click="delete"
                >
                    Delete
                </a>
            @endif
        </div>
    </x-table.cell>
</x-table.row>
