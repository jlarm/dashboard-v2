<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 sm:px-6 lg:px-8">
            <div>
                <h3 class="text-2xl leading-6 font-medium text-arm-green-500">Upcoming Events</h3>
                <livewire:central.event.index/>
                @can('delete-dealerships')
                    <x-primary-button onclick="Livewire.emit('modal.open', 'central.event.create')">Add Event
                    </x-primary-button>
                @endcan
            </div>
        </div>
    </div>
</x-app-layout>
