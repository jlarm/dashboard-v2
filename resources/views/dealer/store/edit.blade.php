<x-store-app :title="$store->name">
    <div class="space-y-6">
        <livewire:dealer.store.edit :store="$store"/>
        <livewire:dealer.general.compliance-form :store="$store"/>
    </div>
</x-store-app>
