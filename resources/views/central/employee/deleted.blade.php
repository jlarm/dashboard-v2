<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Deleted Employees') }}
            </h2>
            <x-primary-button onclick="Livewire.emit('modal.open', 'central.employee.invite')">Invite Employee</x-primary-button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <livewire:central.employee.deleted />
            </div>
        </div>
    </div>
</x-app-layout>
