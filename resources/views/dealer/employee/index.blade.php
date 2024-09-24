<x-dealer-app>
    <div
        class="px-6 py-5 sm:flex sm:items-center sm:justify-between">
        <div class="min-w-0 flex-1">
            <h1 class="text-4xl font-bold text-arm-blue-900 sm:truncate leading-normal">Employees</h1>
        </div>
        <div class="mt-4 flex space-x-5 sm:mt-0 sm:ml-4">
            @if($stores)
                @can('create-dealerships')
                    <x-primary-button onclick="Livewire.emit('modal.open', 'dealer.employee.import')">
                        <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M12 12v6"/><path d="m15 15-3-3-3 3"/></svg>
                        Import
                    </x-primary-button>
                    <a
                        class="inline-flex items-center px-4 py-2 bg-arm-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-arm-blue-700 focus:bg-arm-blue-700 active:bg-arm-blue-900 focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        href="{{ route('dealer.employees.new') }}">Add Employee</a>
                @endcan

                @role('Manager')
                @cannot('create-stores')
                    <x-primary-button onclick="Livewire.emit('modal.open', 'dealer.employee.manager-invite')">Add
                        Employee
                    </x-primary-button>
                @endcannot
                @endrole

                @role('Qualified Individual')
                <x-primary-button onclick="Livewire.emit('modal.open', 'dealer.employee.invite')">Add Employee
                </x-primary-button>
                @endrole
                <a
                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"
                    href="{{ route('dealer.employees.open-invites') }}">Open Invites</a>
            @endif
        </div>
    </div>

    <div class="px-6">
        <div class="p-6 border rounded-xl border-gray-200 shadow-sm">
            @can('edit-stores')
                <livewire:dealer.employee.index/>
            @endcan
            @cannot('edit-stores')
                <livewire:dealer.employee.manager-index/>
            @endcannot
        </div>
    </div>
</x-dealer-app>
