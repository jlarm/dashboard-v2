<div>
    <div>
        <livewire:dealer.store.single-store-sub-nav :store="$store"/>
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-lg font-medium leading-6 text-gray-900">{{ $user->name }}</h1>
                </div>
                <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">

                </div>
            </div>
            <div class="mt-8 flow-root">
                <div class="mx-auto xl:grid xl:grid-cols-3">
                    <div class="xl:col-span-2 xl:border-r xl:border-gray-200 xl:pr-8">
                        <livewire:dealer.employee.course-results :user="$user"/>
                    </div>
                    <div class="hidden xl:block xl:pl-8">
                        <livewire:dealer.employee.details :user="$user"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
