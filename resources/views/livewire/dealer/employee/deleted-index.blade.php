<div>
    <x-slot name="header">
        <x-slot name="pageTitle">Deleted Employees</x-slot>
        <x-slot name="actions">
            <livewire:dealer.employee.sub-nav :store="$store" />
        </x-slot>
    </x-slot>
    <x-table>
        <x-slot:head>
            <x-table.row>
                <x-table.heading>Name</x-table.heading>
                <x-table.heading>Department</x-table.heading>
                <x-table.heading>Date Deleted</x-table.heading>
                <x-table.heading></x-table.heading>
            </x-table.row>
        </x-slot:head>
        <x-slot:body>
            @forelse($users as $user)
                <livewire:dealer.employee.deleted-index-item :user="$user" wire:key="{{ $user->id }}" />
            @empty
                <x-table.row>
                    <td colspan="4" class="text-center py-5">
                        <span>No Employees have been delete</span>
                    </td>
                </x-table.row>
            @endforelse
        </x-slot:body>
    </x-table>
</div>
