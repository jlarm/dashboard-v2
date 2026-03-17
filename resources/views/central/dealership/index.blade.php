<x-app-layout>
    <div class="bg-white rounded-md">
        <div>
            <div class="flex justify-between items-center mb-5">
                <h1 class="text-xl font-bold leading-none tracking-tight text-neutral-900">Dealerships</h1>
                <x-armp.button size="sm" variant="primary" onclick="Livewire.emit('modal.open', 'central.dealership.create')">Add Dealership</x-armp.button>
            </div>
            <livewire:central.dealership.index/>
        </div>
    </div>
</x-app-layout>
