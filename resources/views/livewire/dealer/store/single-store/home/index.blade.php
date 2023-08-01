<div>
    <livewire:dealer.store.single-store-sub-nav :store="$store"/>
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <dl class="grid grid-cols-2 gap-5 text-center lg:grid-cols-4">
            <livewire:dealer.home.osha-stats :store="$store"/>
            <livewire:dealer.home.body-shop-stats :store="$store"/>
            <livewire:dealer.home.glba-stats :store="$store"/>
            <livewire:dealer.home.deal-jacket-stats :store="$store"/>
        </dl>
    </div>
</div>
