<div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl">
    <div class="p-5 pb-4">
        <div class="flex justify-between">
            <div>
                <h2 class="inline-block font-semibold text-gray-800">
                    Stores
                </h2>
                <p class="text-xs text-gray-400 italic">Listings of all stores in your dealer group</p>
            </div>
            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                @can('create-dealerships')
                <button onclick="Livewire.emit('modal.open', 'dealer.store.create')" type="button" class="block rounded-md bg-arm-blue-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-arm-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-arm-blue-600">Add Store</button>
                @endcan
            </div>
        </div>
    </div>
    <livewire:dealer.home.store-list/>
</div> 