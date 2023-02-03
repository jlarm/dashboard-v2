<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dealerships') }}
            </h2>
            <div class="flex space-x-5">
                <x-primary-button
                    onclick="Livewire.emit('modal.open', 'central.dealership.create')"
                >
                    Add Dealership
                </x-primary-button>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @can('delete-users')
                <livewire:central.dealership.index/>
            @endcan
            @cannot('delete-users')
                <livewire:central.dealership.consultant-index/>
            @endcannot
        </div>
    </div>
</x-app-layout>
