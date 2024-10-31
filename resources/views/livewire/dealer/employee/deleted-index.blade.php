<div>
    <div
        class="px-6 py-5 sm:flex sm:items-center sm:justify-between">
        <div class="min-w-0 flex-1">
            <h1 class="text-4xl font-bold text-arm-blue-900 sm:truncate leading-normal">Deleted Employees</h1>
        </div>
        <div class="mt-4 flex space-x-5 sm:mt-0 sm:ml-4">
        </div>
    </div>
    <div class="px-6">
        <div class="p-6 border rounded-xl border-gray-200 shadow-sm">
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
    </div>
</div>
