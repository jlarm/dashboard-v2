<x-store-app :title="$store->name">
    <div class="border-b border-gray-200 px-4 py-4 sm:flex sm:items-center sm:justify-between">
        <div class="min-w-0 flex-1">
            @include('components.navigation.sub-nav', $store)
        </div>
    </div>
    <div class="py-12 space-y-6">
        <!-- General Information -->
        <div class="bg-gray-50 px-4 py-5 shadow sm:rounded-lg sm:p-6">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <h3 class="text-base font-semibold leading-6 text-gray-900">General Information</h3>
                    <p class="mt-1 text-sm text-gray-500">This information will be displayed publicly so be careful what
                        you share.</p>
                </div>
                <div class="mt-5 space-y-6 md:col-span-2 md:mt-0">
                    <livewire:dealer.store.edit :store="$store"/>
                </div>
            </div>
        </div>
        <!-- Compliance Information -->
        <div class="bg-gray-50 px-4 py-5 shadow sm:rounded-lg sm:p-6">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <h3 class="text-base font-semibold leading-6 text-gray-900">Compliance Information</h3>
                    <p class="mt-1 text-sm text-gray-500">Should we put anything here?</p>
                </div>
                <div class="mt-5 space-y-6 md:col-span-2 md:mt-0">
                    <livewire:dealer.general.onboarding-form/>
                </div>
            </div>
        </div>
    </div>
</x-store-app>
