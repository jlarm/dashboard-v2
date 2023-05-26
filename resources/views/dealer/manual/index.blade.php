<x-dealer-app>
    <div class="border-b border-gray-200 px-4 py-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
        <div class="min-w-0 flex-1">
            <h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">Manuals</h1>
        </div>
    </div>

    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-5 px-3 sm:px-0">
                <livewire:dealer.manual.isp-card/>
                <livewire:dealer.manual.osha-card/>
            </div>
        </div>
    </div>
</x-dealer-app>
