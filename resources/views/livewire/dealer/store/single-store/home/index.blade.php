<div>
    <div class="mx-auto px-6 pt-6">
        @can('create-dealerships')
            <div class="col-span-2">
                <livewire:dealer.home.multi-note :store="$store"/>
            </div>
        <h1 class="font-bold text-2xl mt-10 mb-5">Course Completion by Department</h1>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 text-center">
            <div class="border rounded-md flex flex-col justify-center items-center py-10">
                <livewire:dealer.employee.completed-courses-stat :store="$store" :department="0" name="All" />
            </div>
            <div class="border rounded-md flex flex-col justify-center items-center py-10">
                <livewire:dealer.employee.completed-courses-stat :store="$store" :department="1" name="Sales" />
            </div>
            <div class="border rounded-md flex flex-col justify-center items-center py-10">
                <livewire:dealer.employee.completed-courses-stat :store="$store" :department="2" name="Accounting" />
            </div>
            <div class="border rounded-md flex flex-col justify-center items-center py-10">
                <livewire:dealer.employee.completed-courses-stat :store="$store" :department="3" name="Service" />
            </div>
            <div class="border rounded-md flex flex-col justify-center items-center py-10">
                <livewire:dealer.employee.completed-courses-stat :store="$store" :department="4" name="Parts" />
            </div>
            <div class="border rounded-md flex flex-col justify-center items-center py-10">
                <livewire:dealer.employee.completed-courses-stat :store="$store" :department="5" name="Body Shop" />
            </div>
            <div class="border rounded-md flex flex-col justify-center items-center py-10">
                <livewire:dealer.employee.completed-courses-stat :store="$store" :department="6" name="Finance" />
            </div>
            <div class="border rounded-md flex flex-col justify-center items-center py-10">
                <livewire:dealer.employee.completed-courses-stat :store="$store" :department="7" name="Porter/Driver" />
            </div>
        </div>
        @endcan
        <h1 class="font-bold text-2xl mt-10 mb-5">Audit Ratings</h1>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 text-center">
            <livewire:dealer.home.osha-stats :store="$store"/>
            <livewire:dealer.home.body-shop-stats :store="$store"/>
            <livewire:dealer.home.glba-stats :store="$store"/>
            <livewire:dealer.home.deal-jacket-stats :store="$store"/>
        </div>
    </div>
</div>
