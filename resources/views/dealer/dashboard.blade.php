<x-dealer-app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        @if(!tenant('locations'))
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
