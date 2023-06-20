<div>
    <livewire:dealer.store.single-store-sub-nav :store="$store"/>
    <div class="mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-3 xl:grid-cols-4 gap-5 px-4">
            <livewire:dealer.manual.isp-card :store="$store"/>
            <livewire:dealer.manual.osha-card :store="$store"/>
            <livewire:dealer.manual.red-flag-card :store="$store"/>
        </div>
    </div>
</div>
