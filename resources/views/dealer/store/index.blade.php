<x-dealer-app>
    <div class="border-b border-gray-200 px-4 py-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
        <div class="min-w-0 flex-1">
            <h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">Stores</h1>
        </div>
        <div class="mt-4 flex sm:mt-0 sm:ml-4">
            <x-primary-button onclick="Livewire.emit('modal.open', 'store.create')">Add Store</x-primary-button>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <livewire:dealer.store.index/>
            </div>
        </div>
    </div>
</x-dealer-app>
