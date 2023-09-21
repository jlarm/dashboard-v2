<x-dealer-app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        @if(!tenant('locations'))
            @can('create-users')
                <div class="bg-white">
                    <div class="mx-auto px-6 lg:px-8">
                        <dl class="grid grid-cols-2 gap-5 text-center">
                            @can('create-dealerships')
                                <div class="col-span-2">
                                    <livewire:dealer.home.note/>
                                </div>
                            @endcan
                            <div class="col-span-1">
                                <livewire:dealer.general.store-logo/>
                            </div>
                            <div class="col-span-1"></div>
                            <livewire:dealer.home.osha-stats/>
                            <livewire:dealer.home.body-shop-stats/>
                            <livewire:dealer.home.glba-stats/>
                            <livewire:dealer.home.deal-jacket-stats/>
                        </dl>
                    </div>
                </div>
            @endcan
        @endif
        @if(tenant('locations'))
            @can('edit-stores')
                <livewire:dealer.home.store-list/>
            @endcan
        @endif
    </div>
</x-dealer-app>
