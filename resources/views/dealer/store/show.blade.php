<x-store-app :title="$store->name">
    <div class="lg:grid lg:grid-cols-3 lg:gap-5">
        <div class="col-span-2">
            <livewire:dealer.store.employees :store="$store"/>
        </div>
        <div class="col-span-1 bg-gray-50 p-10">
            <livewire:dealer.store.single-store-sub-nav :store="$store"/>
        </div>
    </div>
</x-store-app>
