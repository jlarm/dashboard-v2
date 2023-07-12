<x-dealer-app>
    <div
        class="bg-gray-50 border-b border-gray-200 px-4 py-20 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
        <div class="min-w-0 flex-1">
            <h1 class="text-4xl font-bold text-arm-blue-900 sm:truncate">Employees</h1>
        </div>
        <div class="mt-4 flex space-x-5 sm:mt-0 sm:ml-4">
            @if($stores)
                <x-primary-button onclick="Livewire.emit('modal.open', 'dealer.employee.invite')">Add Employee
                </x-primary-button>
                <a
                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"
                    href="{{ route('dealer.employees.open-invites') }}">Open Invites</a>
            @endif
        </div>
    </div>

    <div class="py-12">
        <div>
            @can('edit-stores')
                <livewire:dealer.employee.index/>
            @endcan
            @cannot('edit-stores')
                <livewire:dealer.employee.manager-index/>
            @endcannot
        </div>
    </div>
</x-dealer-app>
