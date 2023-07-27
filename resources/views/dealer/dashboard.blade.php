<x-dealer-app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        @if(!tenant('locations'))
            @can('create-dealerships')
                <div class="bg-white">
                    <div class="mx-auto max-w-7xl px-6 lg:px-8">
                        <dl class="grid grid-cols-2 gap-5 text-center lg:grid-cols-4">
                            <livewire:dealer.home.deal-jacket-stats/>
                            <livewire:dealer.home.osha-stats/>
                            <livewire:dealer.home.body-shop-stats/>
                            <livewire:dealer.home.glba-stats/>
                        </dl>
                    </div>
                </div>
            @endcan
            <div class="m-20">
                <livewire:dealer.general.store-logo/>
            </div>
        @endif
        @if(tenant('locations'))
            @can('edit-stores')
                <livewire:dealer.home.store-list/>
            @endcan
        @endif
    </div>
</x-dealer-app>
