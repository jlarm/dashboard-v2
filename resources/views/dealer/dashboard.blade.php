<x-dealer-app>
    <div class="space-y-5">
        {{-- Single Location Dealer View --}}
        @if(!tenant('locations'))
            @can('create-stores')
                {{-- Audit Stats --}}
                <x-dealer.dashboard.audit-stats />

                {{-- Course Stats and Consultant Notes --}}
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-2 gap-5">
                    <x-dealer.dashboard.department-completion />

                    @can('create-dealerships')
                        <x-dealer.dashboard.consultant-notes />
                    @endcan

                    @role('Qualified Individual')
                        <div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl">
                            <div class="p-5 pb-4">
                                <livewire:dealer.home.manuals />
                            </div>
                        </div>
                    @endrole
                </div>
            @endcan
        @endif

        {{-- Multiple Locations Dealer Group View --}}
        @if(tenant('locations'))
            @can('edit-stores')
                <livewire:dealer.home.group-rating />
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-2 gap-5">
                    <x-dealer.dashboard.department-completion subtitle="*Based on all stores in your group and the total number of employees who completed required training." />

                    <x-dealer.dashboard.stores-list />
                </div>
            @endcan
        @endif

        {{-- Employee Course View --}}
        @cannot('create-stores')
            <x-dealer.dashboard.course-list />
        @endcannot
    </div>
</x-dealer-app>
