<div class="px-6">
    <div
        class="py-5 sm:flex sm:items-center sm:justify-between">
        <div class="min-w-0 flex-1">
            <h1 class="text-4xl font-bold text-arm-blue-900 sm:truncate leading-normal">Settings</h1>
        </div>
    </div>
    <div class="border rounded-md p-6">
        <div class="divide-y">
            <livewire:dealer.store.single-store-details :store="$store"/>
            <livewire:dealer.settings.employee-list :store="$store"/>
            <livewire:dealer.store.single-onboarding-details :store="$store"/>
        </div>
    </div>
</div>
