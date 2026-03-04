<div class="flex flex-col gap-5 mt-5 sm:flex-row sm:items-center sm:justify-end sm:mt-0 sm:ps-5 text-gray-600">
    <a
        href="{{ $store ? route('dealer.employees.index', $store) : route('dealer.employees.index') }}"
        @class([
            'text-sm focus:outline-none',
            'text-arm-orange-500' => request()->routeIs('dealer.employees.index'),
        ])>Employees</a>
    @can('create-dealerships')
        <a
            href="{{ $store ? route('dealer.employees.new', $store) : route('dealer.employees.new') }}"
            @class([
                'text-sm focus:outline-none',
                'text-arm-orange-500' => request()->routeIs('dealer.employees.new'),
            ])>Invite Employee</a>
    @endcan
    @role('Manager')
    @cannot('create-stores')
        <button
            onclick="Livewire.emit('modal.open', 'dealer.employee.manager-invite')"
            type="button"
            class="text-sm focus:outline-none">Invite Employee
        </button>
    @endcannot
    @endrole

    @role('Qualified Individual')
    <button
        onclick="Livewire.emit('modal.open', 'dealer.employee.invite')"
        type="button"
        class="text-sm focus:outline-none">Invite Employee
    </button>
    @endrole
    @if (request()->segment(1) === 'stores' || !app('multipleStoresExist'))
        <a
            href="{{ $store ? route('dealer.employees.open-invites', $store) : route('dealer.employees.open-invites') }}"
            @class([
                'text-sm focus:outline-none',
                'text-arm-orange-500' => request()->routeIs('dealer.employees.open-invites'),
            ])>Open Invites</a>
    @else

    <a
        href="{{ route('dealer.employees.open-invites') }}"
        @class([
            'text-sm focus:outline-none',
            'text-arm-orange-500' => request()->routeIs('dealer.employees.open-invites'),
        ])>Open Invites</a>
    @endif
    @can('create-stores')
        <a
            href="{{ $store ? route('dealer.employees.deleted', $store) : route('dealer.employees.deleted') }}"
            @class([
                'text-sm focus:outline-none',
                'text-arm-orange-500' => request()->routeIs('dealer.employees.deleted'),
            ])>Deleted</a>
    @endcan
</div>
