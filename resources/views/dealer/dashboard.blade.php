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
                        @endcan
                        <h1 class="font-bold text-2xl mt-10">Course Completion by Department</h1>
                        <p class="text-sm mb-5 text-gray-400 italic">*Based on the total number of employees who finished all required training courses.</p>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 text-center">
                            <a href="{{ route('employees.index') }}" class="h-[223px] border rounded-md flex flex-col justify-center items-center py-10">
                                <livewire:dealer.employee.completed-courses-stat name="All" />
                            </a>
                            <a href="{{ route('employees.index') }}?d=1" class="h-[223px] border rounded-md flex flex-col justify-center items-center py-10">
                                <livewire:dealer.employee.completed-courses-stat :department="1" name="Sales" />
                            </a>
                            <a href="{{ route('employees.index') }}?d=2" class="h-[223px] border rounded-md flex flex-col justify-center items-center py-10">
                                <livewire:dealer.employee.completed-courses-stat :department="2" name="Accounting" />
                            </a>
                            <a href="{{ route('employees.index') }}?d=3" class="h-[223px] border rounded-md flex flex-col justify-center items-center py-10">
                                <livewire:dealer.employee.completed-courses-stat :department="3" name="Service" />
                            </a>
                            <a href="{{ route('employees.index') }}?d=4" class="h-[223px] border rounded-md flex flex-col justify-center items-center py-10">
                                <livewire:dealer.employee.completed-courses-stat :department="4" name="Parts" />
                            </a>
                            <a href="{{ route('employees.index') }}?d=5" class="h-[223px] border rounded-md flex flex-col justify-center items-center py-10">
                                <livewire:dealer.employee.completed-courses-stat :department="5" name="Body Shop" />
                            </a>
                            <a href="{{ route('employees.index') }}?d=6" class="h-[223px] border rounded-md flex flex-col justify-center items-center py-10">
                                <livewire:dealer.employee.completed-courses-stat :department="6" name="Finance" />
                            </a>
                            <a href="{{ route('employees.index') }}?d=7" class="h-[223px] border rounded-md flex flex-col justify-center items-center py-10">
                                <livewire:dealer.employee.completed-courses-stat :department="7" name="Porter/Driver" />
                            </a>
                        </div>
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
                    <div class="p-6">
                        <h1 class="font-bold text-2xl mt-10">Course Completion by Department</h1>
                        <p class="text-sm text-gray-500">Based on all stores in your group</p>
                        <p class="text-sm mb-5 text-gray-400 italic">*Based on the total number of employees who finished all required training courses.</p>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 text-center">
                            <a href="{{ route('employees.index') }}" class="h-[223px] border rounded-md flex flex-col justify-center items-center py-10">
                                <livewire:dealer.employee.completed-courses-stat name="All" />
                            </a>
                            <a href="{{ route('employees.index') }}?d=1" class="h-[223px] border rounded-md flex flex-col justify-center items-center py-10">
                                <livewire:dealer.employee.completed-courses-stat :department="1" name="Sales" />
                            </a>
                            <a href="{{ route('employees.index') }}?d=2" class="h-[223px] border rounded-md flex flex-col justify-center items-center py-10">
                                <livewire:dealer.employee.completed-courses-stat :department="2" name="Accounting" />
                            </a>
                            <a href="{{ route('employees.index') }}?d=3" class="h-[223px] border rounded-md flex flex-col justify-center items-center py-10">
                                <livewire:dealer.employee.completed-courses-stat :department="3" name="Service" />
                            </a>
                            <a href="{{ route('employees.index') }}?d=4" class="h-[223px] border rounded-md flex flex-col justify-center items-center py-10">
                                <livewire:dealer.employee.completed-courses-stat :department="4" name="Parts" />
                            </a>
                            <a href="{{ route('employees.index') }}?d=5" class="h-[223px] border rounded-md flex flex-col justify-center items-center py-10">
                                <livewire:dealer.employee.completed-courses-stat :department="5" name="Body Shop" />
                            </a>
                            <a href="{{ route('employees.index') }}?d=6" class="h-[223px] border rounded-md flex flex-col justify-center items-center py-10">
                                <livewire:dealer.employee.completed-courses-stat :department="6" name="Finance" />
                            </a>
                            <a href="{{ route('employees.index') }}?d=7" class="h-[223px] border rounded-md flex flex-col justify-center items-center py-10">
                                <livewire:dealer.employee.completed-courses-stat :department="7" name="Porter/Driver" />
                            </a>
                        </div>
                    </div>
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
