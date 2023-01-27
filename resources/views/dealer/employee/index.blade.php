<x-dealer-app>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Employees') }}
            </h2>
            <x-primary-button onclick="Livewire.emit('modal.open', 'dealer.employee.invite')">Invite Employee</x-primary-button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <livewire:dealer.employee.index />
            </div>
        </div>
    </div>
</x-dealer-app>
