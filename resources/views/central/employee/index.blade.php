<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Employees') }}
            </h2>
            <div class="flex space-x-5">
                <x-primary-button onclick="Livewire.emit('modal.open', 'central.employee.invite')">Invite Employee
                </x-primary-button>
                @can('delete-users')
                    <a
                        class="inline-flex items-center rounded border border-gray-300 bg-white px-2.5 py-1.5 text-xs font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2"
                        href="{{ route('employees.deleted') }}"
                    >
                        Deleted Employees
                    </a>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <livewire:central.employee.index/>
        </div>
    </div>
</x-app-layout>
