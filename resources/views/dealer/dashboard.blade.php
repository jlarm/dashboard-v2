<x-dealer-app>
        <div class="p-5 space-y-5">
        @if(!tenant('locations'))
            @can('create-stores')
{{--             Audit Stats--}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-2 md:gap-3 xl:gap-5">
                <livewire:dealer.home.osha-stats/>
                <livewire:dealer.home.body-shop-stats/>
                <livewire:dealer.home.glba-stats/>
                <livewire:dealer.home.deal-jacket-stats/>
            </div>

{{--            Course Stats--}}
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-2 gap-5">
                <div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl">
                    <!-- Header -->
                    <div class="p-5 pb-4">
                        <div>
                            <h2 class="inline-block font-semibold text-gray-800">
                                Course Completion by Department
                            </h2>
                            <p class="text-xs mb-5 text-gray-400 italic">*Based on the total number of employees who finished all required training courses.</p>
                        </div>
                        <!-- End Col -->
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    <div class="h-full p-5 pt-0 space-y-4">
                        <!-- List Group -->
                        <ul class="space-y-4">
                            <livewire:dealer.employee.completed-courses-stat name="All" />
                            <livewire:dealer.employee.completed-courses-stat :department="1" name="Sales" />
                            <livewire:dealer.employee.completed-courses-stat :department="2" name="Accounting" />
                            <livewire:dealer.employee.completed-courses-stat :department="3" name="Service" />
                            <livewire:dealer.employee.completed-courses-stat :department="4" name="Parts" />
                            <livewire:dealer.employee.completed-courses-stat :department="5" name="Body Shop" />
                            <livewire:dealer.employee.completed-courses-stat :department="6" name="Finance" />
                            <livewire:dealer.employee.completed-courses-stat :department="7" name="Porter/Driver" />
                        </ul>
                        <!-- End List Group -->
                    </div>
                    <!-- End Body -->
                </div>
                <div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl">
                    @can('create-dealerships')
                    <!-- Header -->
                    <div class="p-5 pb-4">
                        <div>
                            <h2 class="inline-block font-semibold text-gray-800">
                                Consultant Notes
                            </h2>
                            <p class="text-xs mb-5 text-gray-400 italic">Add any notes you would like to refer back to. Only you as the consultant will see these notes.</p>
                        </div>
                        <!-- End Col -->
                    </div>
                    <!-- End Header -->

                    <div class="h-full p-5 pt-0 space-y-4">
                        <livewire:dealer.home.note/>
                    </div>
                    @endcan
                    @role('Qualified Individual')
                        <div class="p-5 pb-4">
                            <livewire:dealer.home.manuals />
                        </div>
                    @endrole
                </div>
            </div>
            @endcan
        @endif

        @if(tenant('locations'))
            @can('edit-stores')
                    {{--            Course Stats--}}
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-2 gap-5">
                        <div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl">
                            <!-- Header -->
                            <div class="p-5 pb-4">
                                <div>
                                    <h2 class="inline-block font-semibold text-gray-800">
                                        Course Completion by Department
                                    </h2>
                                    <p class="text-xs text-gray-400 italic">*Based on all stores in your group</p>
                                    <p class="text-xs mb-5 text-gray-400 italic">**Based on the total number of employees who finished all required training courses.</p>
                                </div>
                                <!-- End Col -->
                            </div>
                            <!-- End Header -->

                            <!-- Body -->
                            <div class="h-full p-5 pt-0 space-y-4">
                                <!-- List Group -->
                                <ul class="space-y-4">
                                    <livewire:dealer.employee.completed-courses-stat name="All" />
                                    <livewire:dealer.employee.completed-courses-stat :department="1" name="Sales" />
                                    <livewire:dealer.employee.completed-courses-stat :department="2" name="Accounting" />
                                    <livewire:dealer.employee.completed-courses-stat :department="3" name="Service" />
                                    <livewire:dealer.employee.completed-courses-stat :department="4" name="Parts" />
                                    <livewire:dealer.employee.completed-courses-stat :department="5" name="Body Shop" />
                                    <livewire:dealer.employee.completed-courses-stat :department="6" name="Finance" />
                                    <livewire:dealer.employee.completed-courses-stat :department="7" name="Porter/Driver" />
                                </ul>
                                <!-- End List Group -->
                            </div>
                            <!-- End Body -->
                        </div>
                        <div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl">
                            <!-- Header -->
                            <div class="p-5 pb-4">
                                <div class="flex justify-between">
                                    <div>
                                        <h2 class="inline-block font-semibold text-gray-800">
                                            Stores
                                        </h2>
                                        <p class="text-xs text-gray-400 italic">Listings of all stores in your dealer group</p>
                                    </div>
                                    <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                                        <button onclick="Livewire.emit('modal.open', 'dealer.store.create')" type="button" class="block rounded-md bg-arm-blue-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-arm-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-arm-blue-600">Add Store</button>
                                    </div>
                                </div>
                                <!-- End Col -->
                            </div>
                            <!-- End Header -->
                            <livewire:dealer.home.store-list/>
                        </div>
                    </div>
                    <livewire:dealer.home.group-rating />
            @endcan
        @endif
        @cannot('create-stores')
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
