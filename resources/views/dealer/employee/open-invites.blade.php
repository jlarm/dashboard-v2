<x-dealer-app>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Open Invites') }}
            </h2>
            <div class="space-x-5">
                <x-primary-button onclick="Livewire.emit('modal.open', 'dealer.employee.invite')">Invite Employee</x-primary-button>
                <a href="{{ route('dealer.employees.open-invites') }}">Open Invites</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div>
                <livewire:dealer.employee.open-invites />
            </div>
        </div>
    </div>
</x-dealer-app>
