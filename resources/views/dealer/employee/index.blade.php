<x-dealer-app>
    <x-slot name="header">
        <x-slot name="pageTitle">Employees</x-slot>
        <x-slot name="actions">
            <div class="flex flex-col gap-5 mt-5 sm:flex-row sm:items-center sm:justify-end sm:mt-0 sm:ps-5">
                <a
                    href="{{ route('dealer.employees.index') }}"
                    @class([
                        'text-sm focus:outline-none',
                        'text-arm-orange-500' => request()->routeIs('dealer.employees.index'),
                        'text-gray-600' => !request()->routeIs('dealer.employees.index')
                    ])>Employees</a>
                @can('create-dealerships')
                <button
                    onclick="Livewire.emit('modal.open', 'dealer.employee.import')"
                    type="button"
                    class="text-sm focus:outline-none">Import</button>
                <a
                    href="{{ route('dealer.employees.new') }}"
                    @class([
                        'text-sm focus:outline-none',
                        'text-arm-orange-500' => request()->routeIs('dealer.employees.new'),
                        'text-gray-600' => !request()->routeIs('dealer.employees.new')
                    ])>Invite Employee</a>
                @endcan
                @role('Manager')
                @cannot('create-stores')
                    <button type="button" onclick="Livewire.emit('modal.open', 'dealer.employee.manager-invite')" class="text-sm focus:outline-none">Invite Employee</button>
                @endcannot
                @endrole
                @role('Qualified Individual')
                    <button type="button" onclick="Livewire.emit('modal.open', 'dealer.employee.invite')" class="text-sm focus:outline-none">Invite Employee</button>
                @endrole
                <a
                    href="{{ route('dealer.employees.open-invites') }}"
                    @class([
                        'text-sm focus:outline-none',
                        'text-arm-orange-500' => request()->routeIs('dealer.employees.open-invites'),
                        'text-gray-600' => !request()->routeIs('dealer.employees.open-invites')
                    ])>Open Invites</a>
                @can('create-stores')
                    <a
                        href="{{ route('dealer.employee.deleted') }}"
                        @class([
                            'text-sm focus:outline-none',
                            'text-arm-orange-500' => request()->routeIs('dealer.employee.deleted'),
                            'text-gray-600' => !request()->routeIs('dealer.employee.deleted')
                        ])>Deleted</a>
                @endcan
            </div>
        </x-slot>
    </x-slot>
    @if(tenant('locations'))
        @can('edit-stores')
            <livewire:dealer.employee.index/>
        @endcan
        @cannot('edit-stores')
            <livewire:dealer.employee.manager-index/>
        @endcannot
    @else
        <livewire:dealer.employee.index/>
    @endif
</x-dealer-app>
