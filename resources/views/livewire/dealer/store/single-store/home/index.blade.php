<div>
    <livewire:dealer.store.single-store-sub-nav :store="$store"/>
    <div class="mx-auto px-6 lg:px-8">
        <dl class="grid grid-cols-2 gap-5 text-center">
            @can('create-stores')
                <div class="col-span-2">
                    <livewire:dealer.home.multi-note :store="$store"/>
                </div>
            @endcan
            <div class="col-span-1">
                <livewire:dealer.general.multi-store-logo :store="$store"/>
            </div>
            <div class="col-span-1"></div>
            <livewire:dealer.home.osha-stats :store="$store"/>
            <livewire:dealer.home.body-shop-stats :store="$store"/>
            <livewire:dealer.home.glba-stats :store="$store"/>
            <livewire:dealer.home.deal-jacket-stats :store="$store"/>
        </dl>
    </div>
</div>
