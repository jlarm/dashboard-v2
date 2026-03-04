<div>
    <x-slot name="header">
        <x-slot name="pageTitle">Deleted Employees</x-slot>
        <x-slot name="actions">
            <livewire:dealer.employee.sub-nav :store="$store" />
        </x-slot>
    </x-slot>
    <div class="w-full px-3 sm:px-0 mb-5 flex justify-between">
        <div class="flex gap-x-2">
            <div>
                <label for="search" class="sr-only">Search</label>
                <input
                    type="search"
                    name="search"
                    id="search"
                    wire:model.debounce.300ms="search"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"
                    placeholder="Search by Name or Email..."
                >
            </div>
            @if($search !== '')
                <x-secondary-button wire:click="clearSearch">Clear</x-secondary-button>
            @endif
        </div>
    </div>
    <x-table>
        <x-slot name="head">
            <x-table.heading>Name</x-table.heading>
            <x-table.heading>Department</x-table.heading>
            <x-table.heading>Date Deleted</x-table.heading>
            <x-table.heading class="text-right"></x-table.heading>
        </x-slot>
        <x-slot name="body">
            @forelse($users as $user)
                <x-table.row wire:key="deleted-user-{{ $user->id }}">
                    <x-table.cell class="pl-4 pr-3">{{ Str::title($user->name) }}</x-table.cell>
                    <x-table.cell class="pl-4 pr-3">{{ $user->department?->name ?? 'N/A' }}</x-table.cell>
                    <x-table.cell class="pl-4 pr-3">{{ $user->deleted_at?->format('F d, Y') }}</x-table.cell>
                    <x-table.cell class="flex justify-end gap-3">
                        <livewire:dealer.employee.restore :user="$user" :key="'restore-'.$user->id" />
                    </x-table.cell>
                </x-table.row>
            @empty
                <x-table.row>
                    <x-table.cell colspan="4" class="text-center py-5">No employees have been deleted.</x-table.cell>
                </x-table.row>
            @endforelse
        </x-slot>
    </x-table>
    <div class="mt-10">
        {{ $users->links() }}
    </div>
</div>
