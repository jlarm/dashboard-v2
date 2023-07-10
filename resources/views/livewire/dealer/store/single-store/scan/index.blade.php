<div>
    <livewire:dealer.store.single-store-sub-nav :store="$store"/>
    <div class="w-full border-b border-gray-200 px-4 py-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
        <div class="w-full grid grid-cols-1 sm:grid-cols-2">
            <h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">Scans</h1>
            @role('super-admin|Consultant')
            @if(Cookie::get('sentry'))
                <livewire:dealer.store.single-store.scan.generate-report :store="$store"/>
            @endif
            @endrole
        </div>
    </div>

    <div class="py-12">
        <div class="mx-auto">
            @role('super-admin|Consultant')
            @if(!Cookie::get('sentry'))
                <livewire:dealer.store.single-store.scan.login :store="$store"/>
            @endif
            @endrole
            <livewire:dealer.store.single-store.scan.index-list :store="$store"/>
        </div>
    </div>
</div>
