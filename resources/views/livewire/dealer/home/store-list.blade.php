<div class="px-4 sm:px-6 lg:px-8 mt-10">
    <div class="sm:flex sm:items-center">
        @if(Route::is('dealer.dashboard'))
            <div class="sm:flex-auto">
                <h1 class="text-base font-semibold leading-6 text-gray-900">Stores</h1>
                <p class="mt-2 text-sm text-gray-700">A list of all the stores in your account .</p>
            </div>
        @endif
        <div>
            <label for="search" class="sr-only">Search</label>
            <input type="search" name="search" id="search"
                   wire:model="search"
                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"
                   placeholder="Search Stores...">
        </div>
        @if(Route::is('dealer.dashboard'))
            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                <x-primary-button onclick="Livewire.emit('modal.open', 'dealer.store.create')">Add Store
                </x-primary-button>
            </div>
        @endif
    </div>
    <div class="mt-8 flow-root">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead>
                    <tr>
                        <th scope="col"
                            class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 lg:pl-8">Name
                        </th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Address</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Phone Number
                        </th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Website</th>
                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6 lg:pr-8">
                            <span class="sr-only">View</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse($stores as $store)
                        <livewire:dealer.home.store-list-item :store="$store"/>
                    @empty
                        <tr>
                            <td colspan="5"
                                class="px-4 py-4 text-center text-xl text-arm-blue-500 font-medium sm:pr-6 space-x-3">
                                No Stores Created
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-10">
                {{ $stores->links() }}
            </div>
        </div>
    </div>
</div>
