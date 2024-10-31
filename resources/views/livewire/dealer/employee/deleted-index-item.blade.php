<x-table.row>
    <x-table.cell>{{ $user->name }}</x-table.cell>
    <x-table.cell>{{ $user->department->name }}</x-table.cell>
    <x-table.cell>{{ $user->deleted_at?->format('F d, Y') }}</x-table.cell>
    <x-table.cell class="text-right">
        <button wire:click="restoreEmployee" type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent text-arm-blue-600 hover:bg-arm-blue-100 hover:text-arm-blue-800 focus:outline-none focus:bg-arm-blue-100 focus:text-arm-blue-800 active:bg-arm-blue-100 active:text-arm-blue-800 disabled:opacity-50 disabled:pointer-events-none">
            Restore
        </button>
    </x-table.cell>
</x-table.row>
