<x-dealer-app>
        <div>
        @if(!tenant('locations'))
            @can('create-users')
                <div class="bg-white">
                    <div class="mx-auto px-6 lg:px-8 pt-6">
                        @can('create-dealerships')
                            <div class="col-span-full">
                                <livewire:dealer.home.note/>
                            </div>
                        <h1 class="font-bold text-2xl mt-10 mb-5">Course Completion by Department</h1>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 text-center">
                            <div class="h-[223px] border rounded-md flex flex-col justify-center items-center py-10">
                                <livewire:dealer.employee.completed-courses-stat name="All" />
                            </div>
                            <div class="h-[223px] border rounded-md flex flex-col justify-center items-center py-10">
                                <livewire:dealer.employee.completed-courses-stat :department="1" name="Sales" />
                            </div>
                            <div class="h-[223px] border rounded-md flex flex-col justify-center items-center py-10">
                                <livewire:dealer.employee.completed-courses-stat :department="2" name="Accounting" />
                            </div>
                            <div class="h-[223px] border rounded-md flex flex-col justify-center items-center py-10">
                                <livewire:dealer.employee.completed-courses-stat :department="3" name="Service" />
                            </div>
                            <div class="h-[223px] border rounded-md flex flex-col justify-center items-center py-10">
                                <livewire:dealer.employee.completed-courses-stat :department="4" name="Parts" />
                            </div>
                            <div class="h-[223px] border rounded-md flex flex-col justify-center items-center py-10">
                                <livewire:dealer.employee.completed-courses-stat :department="5" name="Body Shop" />
                            </div>
                            <div class="h-[223px] border rounded-md flex flex-col justify-center items-center py-10">
                                <livewire:dealer.employee.completed-courses-stat :department="6" name="Finance" />
                            </div>
                            <div class="h-[223px] border rounded-md flex flex-col justify-center items-center py-10">
                                <livewire:dealer.employee.completed-courses-stat :department="7" name="Porter/Driver" />
                            </div>
                        </div>
                        @endcan
                        <h1 class="font-bold text-2xl mt-10 mb-5">Audit Ratings</h1>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 text-center">
                            <livewire:dealer.home.osha-stats/>
                            <livewire:dealer.home.body-shop-stats/>
                            <livewire:dealer.home.glba-stats/>
                            <livewire:dealer.home.deal-jacket-stats/>
                        </div>
{{--                        <dl class="grid grid-cols-4 gap-5 text-center">--}}
{{--                            <div class="col-span-1">--}}
{{--                                <livewire:dealer.general.store-logo/>--}}
{{--                            </div>--}}
{{--                        </dl>--}}
                    </div>
                </div>
            @endcan
        @endif
        @if(tenant('locations'))
            @can('edit-stores')
                    <livewire:dealer.home.group-rating />
                    <livewire:dealer.home.store-list/>
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
