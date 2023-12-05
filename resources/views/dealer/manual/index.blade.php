<x-dealer-app>
    <div
        class="px-6 py-5 sm:flex sm:items-center sm:justify-between">
        <div class="min-w-0 flex-1">
            <h1 class="text-4xl font-bold text-arm-blue-900 sm:truncate leading-normal">Manuals</h1>
        </div>
    </div>

    <div>
        <div class="px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-5">
                <livewire:dealer.manual.isp-card :store="$store"/>
                <livewire:dealer.manual.osha-card :store="$store"/>
                <livewire:dealer.manual.red-flag-card :store="$store"/>
            </div>
        </div>
    </div>
</x-dealer-app>
