<x-dealer-app>
    <div>
        @if(!tenant('locations'))
            @can('create-users')
                <div class="bg-white">
                    <div class="mx-auto px-6 lg:px-8 pt-6">
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
{{--                    <livewire:dealer.home.group-rating />--}}
{{--                    <livewire:dealer.home.store-list/>--}}
            @endcan
        @endif
        @cannot('create-users')
                <div class="px-6 py-4 sm:flex sm:items-center sm:justify-between">
                    <div class="min-w-0 flex-1">
                        <h1 class="text-4xl font-bold text-arm-blue-900 sm:truncate leading-normal">{{ __('Courses') }}</h1>
                    </div>
                    <livewire:dealer.course.dot-cert />
                </div>
                <div class="px-6">
                    <div class="border rounded-md">
                        <div class="p-6">
                            <livewire:dealer.course.index/>
                        </div>
                    </div>
                </div>
        @endcannot
    </div>
</x-dealer-app>
