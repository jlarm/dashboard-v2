<x-dealer-app>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Employees') }}
            </h2>
            <div class="space-x-5">
                <x-primary-button onclick="Livewire.emit('modal.open', 'dealer.employee.invite')">Invite Employee</x-primary-button>
                <a href="{{ route('dealer.employees.open-invites') }}">Open Invites</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                @can('edit-stores')
                    <livewire:dealer.employee.index />
                @endcan
                @cannot('edit-stores')
                    <livewire:dealer.employee.manager-index />
                @endcannot
            </div>
        </div>
    </div>
</x-dealer-app>
