<x-dealer-app>
    <div class="border-b border-gray-200 px-4 py-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
        <div class="min-w-0 flex-1">
            <h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">Settings</h1>
        </div>
        <div class="mt-4 flex sm:mt-0 sm:ml-4">

        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-6">
                <livewire:dealer.store.single-store-details :store="$store"/>
                <livewire:dealer.settings.employee-list :store="$store"/>
                <livewire:dealer.store.single-onboarding-details :store="$store"/>
            </div>
        </div>
    </div>
</x-dealer-app>
