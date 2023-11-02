<div class="grid grid-cols-1 lg:grid-cols-8 gap-4">
    <div class="bg-white rounded-md p-6 col-span-4">
        <h3 class="text-xl font-bold leading-none tracking-tight text-neutral-900">Upcoming Eventsz</h3>
        <livewire:central.event.index/>
        @can('delete-dealerships')
            <x-primary-button onclick="Livewire.emit('modal.open', 'central.event.create')">Add Event
            </x-primary-button>
        @endcan
    </div>
    <div class="bg-white rounded-md p-4 col-span-4">
    </div>
</div>
