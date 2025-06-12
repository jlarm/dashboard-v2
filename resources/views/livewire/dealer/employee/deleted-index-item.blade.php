<x-table.row>
    <x-table.cell>{{ $user->name }}</x-table.cell>
    <x-table.cell>{{ $user->department->name }}</x-table.cell>
    <x-table.cell>{{ $user->deleted_at?->format('F d, Y') }}</x-table.cell>
    <x-table.cell class="text-right">
        <livewire:dealer.employee.restore :user="$user" />
    </x-table.cell>
</x-table.row>
