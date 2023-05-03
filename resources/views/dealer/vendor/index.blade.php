<x-dealer-app>
    <div
        class="bg-gray-50 border-b border-gray-200 px-4 py-20 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
        <div class="min-w-0 flex-1">
            <h1 class="text-4xl font-bold text-arm-blue-900 sm:truncate">Vendors</h1>
        </div>
        <div class="mt-4 flex sm:mt-0 sm:ml-4">
            <x-primary-button onclick="Livewire.emit('modal.open', 'dealer.vendor.create')">Add Vendor
            </x-primary-button>
        </div>
    </div>

    <div class="py-12">
        <div class="mx-auto">
            <livewire:dealer.vendor.index/>
        </div>
    </div>
</x-dealer-app>
