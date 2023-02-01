<x-dealer-app>
    <div class="border-b border-gray-200 px-4 py-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
        <div class="min-w-0 flex-1">
            <h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">Employees</h1>
        </div>
        <div class="mt-4 flex  space-x-5 sm:mt-0 sm:ml-4">
            <x-primary-button onclick="Livewire.emit('modal.open', 'dealer.employee.invite')">Add Employee
            </x-primary-button>
            <a href="{{ route('dealer.employees.open-invites') }}">Open Invites</a>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="shadow-sm sm:rounded-lg">
                @can('edit-stores')
                    <livewire:dealer.employee.index/>
                @endcan
                @cannot('edit-stores')
                    <livewire:dealer.employee.manager-index/>
                @endcannot
            </div>
        </div>
    </div>
</x-dealer-app>
