<x-app-layout>
    <div class="py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
            <div class="p-5 space-y-4 flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl">
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
