<div class="space-y-5">
    {{--             Audit Stats--}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-2 md:gap-3 xl:gap-5">
        <livewire:dealer.home.osha-stats :store="$store" />
        <livewire:dealer.home.body-shop-stats :store="$store" />
        <livewire:dealer.home.glba-stats :store="$store" />
        <livewire:dealer.home.deal-jacket-stats :store="$store" />
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
                    <livewire:dealer.employee.completed-courses-stat :store="$store" name="All" />
                    <livewire:dealer.employee.completed-courses-stat :store="$store" :department="1" name="Sales" />
                    <livewire:dealer.employee.completed-courses-stat :store="$store" :department="2" name="Accounting" />
                    <livewire:dealer.employee.completed-courses-stat :store="$store" :department="3" name="Service" />
                    <livewire:dealer.employee.completed-courses-stat :store="$store" :department="4" name="Parts" />
                    <livewire:dealer.employee.completed-courses-stat :store="$store" :department="5" name="Body Shop" />
                    <livewire:dealer.employee.completed-courses-stat :store="$store" :department="6" name="Finance" />
                    <livewire:dealer.employee.completed-courses-stat :store="$store" :department="7" name="Porter/Driver" />
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
                    <livewire:dealer.home.note :store="$store"/>
                </div>
            @endcan
            @role('Qualified Individual')
            <div class="p-5 pb-4">
                <livewire:dealer.home.manuals :store="$store" />
            </div>
            @endrole
        </div>
    </div>
</div>
