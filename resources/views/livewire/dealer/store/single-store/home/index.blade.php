<div>
    <div class="mx-auto px-6 pt-6">
        @can('create-dealerships')
            <div class="col-span-2">
                <livewire:dealer.home.multi-note :store="$store"/>
            </div>
        @endcan
        <h1 class="font-bold text-2xl mt-10 mb-5">Course Completion by Department</h1>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 text-center">
            <a href="{{ route('dealer.stores.employees', $store) }}" class="h-[223px] border rounded-md flex flex-col justify-center items-center py-10">
                <livewire:dealer.employee.completed-courses-stat :store="$store" name="All" />
            </a>
            <a href="{{ route('dealer.stores.employees', $store) }}?d=1" class="h-[223px] border rounded-md flex flex-col justify-center items-center py-10">
                <livewire:dealer.employee.completed-courses-stat :store="$store" :department="1" name="Sales" />
            </a>
            <a href="{{ route('dealer.stores.employees', $store) }}?d=2" class="h-[223px] border rounded-md flex flex-col justify-center items-center py-10">
                <livewire:dealer.employee.completed-courses-stat :store="$store" :department="2" name="Accounting" />
            </a>
            <a href="{{ route('dealer.stores.employees', $store) }}?d=3" class="h-[223px] border rounded-md flex flex-col justify-center items-center py-10">
                <livewire:dealer.employee.completed-courses-stat :store="$store" :department="3" name="Service" />
            </a>
            <a href="{{ route('dealer.stores.employees', $store) }}?d=4" class="h-[223px] border rounded-md flex flex-col justify-center items-center py-10">
                <livewire:dealer.employee.completed-courses-stat :store="$store" :department="4" name="Parts" />
            </a>
            <a href="{{ route('dealer.stores.employees', $store) }}?d=5" class="h-[223px] border rounded-md flex flex-col justify-center items-center py-10">
                <livewire:dealer.employee.completed-courses-stat :store="$store" :department="5" name="Body Shop" />
            </a>
            <a href="{{ route('dealer.stores.employees', $store) }}?d=6" class="h-[223px] border rounded-md flex flex-col justify-center items-center py-10">
                <livewire:dealer.employee.completed-courses-stat :store="$store" :department="6" name="Finance" />
            </a>
            <a href="{{ route('dealer.stores.employees', $store) }}?d=7" class="h-[223px] border rounded-md flex flex-col justify-center items-center py-10">
                <livewire:dealer.employee.completed-courses-stat :store="$store" :department="7" name="Porter/Driver" />
            </a>
        </div>
        <h1 class="font-bold text-2xl mt-10 mb-5">Audit Ratings</h1>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 text-center">
            <livewire:dealer.home.osha-stats :store="$store"/>
            <livewire:dealer.home.body-shop-stats :store="$store"/>
            <livewire:dealer.home.glba-stats :store="$store"/>
            <livewire:dealer.home.deal-jacket-stats :store="$store"/>
        </div>
    </div>
</div>
