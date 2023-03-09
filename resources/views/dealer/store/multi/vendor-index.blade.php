<x-store-app :title="$store->name">
    <div class="mb-5 flex justify-end">
        <x-primary-button onclick="Livewire.emit('modal.open', 'dealer.vendor.create')">Add Vendor
        </x-primary-button>
    </div>
    <livewire:dealer.store.multi.vendor-index :store="$store"/>
</x-store-app>
