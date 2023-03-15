<x-store-app :title="$store->name">
    <div class="border-b border-gray-200 px-4 py-4 sm:flex sm:items-center sm:justify-between">
        <div class="min-w-0 flex-1">
            @include('components.navigation.sub-nav', $store)
        </div>
        <div class="mt-4 flex space-x-5 sm:mt-0 sm:ml-4">
            <button
                onclick="Livewire.emit('slide-over.open', 'dealer.store.edit', @js(['store' => $store->id]))"
                class="sm:order-0 order-1 ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-arm-arm-blue-500 focus:ring-offset-2 sm:ml-0">
                Edit
            </button>

            @if(!$userCount)
                <button
                    onclick="Livewire.emit('modal.open', 'dealer.store.delete', @js(['store' => $store->id]))"
                    class="sm:order-0 order-1 ml-3 inline-flex items-center rounded-md bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:ml-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                    </svg>
                </button>
            @endif
        </div>
    </div>

    <div class="py-12">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8 xl:grid xl:max-w-7xl xl:grid-cols-3">
            <div class="xl:col-span-2 xl:border-r xl:border-gray-200 xl:pr-8">
                <livewire:dealer.store.employees :store="$store"/>
            </div>
            <div class="hidden xl:block xl:pl-8">
                <livewire:dealer.store.details :store="$store"/>
            </div>
        </div>
    </div>
</x-store-app>
