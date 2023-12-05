<x-dealer-app>
    <div
        class="px-6 py-5 sm:flex sm:items-center sm:justify-between">
        <div class="min-w-0 flex-1">
            <h1 class="text-4xl font-bold text-arm-blue-900 sm:truncate leading-normal">Vendors</h1>
        </div>
        <div class="mt-4 flex sm:mt-0 sm:ml-4">
            @can('create-stores')
                @if($stores)
                    <x-primary-button onclick="Livewire.emit('modal.open', 'dealer.vendor.create')">Add Vendor
                    </x-primary-button>
                @endif
            @endcan
        </div>
    </div>

    <div class="px-6">
        <div class="mx-auto">
            @if(tenant('locations'))
            <livewire:dealer.vendor.index/>
            @else
            <livewire:dealer.vendor.single-index/>
            @endif
        </div>
    </div>
</x-dealer-app>
