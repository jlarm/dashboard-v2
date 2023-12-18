<div class="px-6 mt-6">
    <div class="border rounded-md p-6">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-base font-semibold leading-6 text-gray-900">Stores</h1>
                <p class="mt-2 text-sm text-gray-700">Listings of all stores in your dealer group.</p>
            </div>
            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                <button onclick="Livewire.emit('modal.open', 'dealer.store.create')" type="button" class="block rounded-md bg-arm-blue-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-arm-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-arm-blue-600">Add Store</button>
            </div>
        </div>
        <div class="mt-8 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead>
                        <tr>
                            <th scope="col" class="whitespace-nowrap py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Name</th>
                            <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">Overall</th>
                            <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">Deal Jackets</th>
                            <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">OSHA</th>
                            <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">GLBA</th>
                            <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">Body Shop</th>
                            <th scope="col" class="relative whitespace-nowrap py-3.5 pl-3 pr-4 sm:pr-0">
                                <span class="sr-only">Edit</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse($stores as $store)
                        <tr class="hover:cursor-pointer" onclick="window.location='{{ route('dealer.stores.home', $store) }}'">
                            <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm text-gray-500 sm:pl-0">{{ $store->name }}</td>
                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">
                                <span class="@if($store->overall_grade == 'A') bg-green-100 text-green-700
                                    @elseif($store->overall_grade == 'B') bg-blue-100 text-blue-700
                                    @elseif($store->overall_grade == 'C') bg-orange-100 text-orange-700
                                    @elseif($store->overall_grade == 'D') bg-red-100 text-red-700
                                    @elseif($store->overall_grade == 'F') bg-red-100 text-red-700
                                    @else
                                    @endif
                                    inline-flex h-6 w-6 items-center justify-center rounded-full">
                                    {{ $store->overall_grade ?? '-' }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-900">
                                <span class="@if($store->deal_jacket_grade == 'A') bg-green-100 text-green-700
                                    @elseif($store->deal_jacket_grade == 'B') bg-blue-100 text-blue-700
                                    @elseif($store->deal_jacket_grade == 'C') bg-orange-100 text-orange-700
                                    @elseif($store->deal_jacket_grade == 'D') bg-red-100 text-red-700
                                    @elseif($store->deal_jacket_grade == 'F') bg-red-100 text-red-700
                                    @else
                                    @endif
                                    inline-flex h-6 w-6 items-center justify-center rounded-full">
                                        {{ $store->deal_jacket_grade ?? '-' }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-500">
                                <span class="@if($store->osha_grade == 'A') bg-green-100 text-green-700
                                    @elseif($store->osha_grade == 'B') bg-blue-100 text-blue-700
                                    @elseif($store->osha_grade == 'C') bg-orange-100 text-orange-700
                                    @elseif($store->osha_grade == 'D') bg-red-100 text-red-700
                                    @elseif($store->osha_grade == 'F') bg-red-100 text-red-700
                                    @else
                                    @endif
                                    inline-flex h-6 w-6 items-center justify-center rounded-full">
                                        {{ $store->osha_grade ?? '-' }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-500">
                                <span class="@if($store->glba_grade == 'A') bg-green-100 text-green-700
                                    @elseif($store->glba_grade == 'B') bg-blue-100 text-blue-700
                                    @elseif($store->glba_grade == 'C') bg-orange-100 text-orange-700
                                    @elseif($store->glba_grade == 'D') bg-red-100 text-red-700
                                    @elseif($store->glba_grade == 'F') bg-red-100 text-red-700
                                    @else
                                    @endif
                                    inline-flex h-6 w-6 items-center justify-center rounded-full">
                                        {{ $store->glba_grade ?? '-' }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-500">
                                <span class="@if($store->body_shop_grade == 'A') bg-green-100 text-green-700
                                    @elseif($store->body_shop_grade == 'B') bg-blue-100 text-blue-700
                                    @elseif($store->body_shop_grade == 'C') bg-orange-100 text-orange-700
                                    @elseif($store->body_shop_grade == 'D') bg-red-100 text-red-700
                                    @elseif($store->body_shop_grade == 'F') bg-red-100 text-red-700
                                    @else
                                    @endif
                                    inline-flex h-6 w-6 items-center justify-center rounded-full">
                                        {{ $store->body_shop_grade ?? '-' }}
                                </span>
                            </td>
                            <td class="relative whitespace-nowrap py-2 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                <a href="{{ route('dealer.stores.home', $store) }}" class="text-arm-blue-600 hover:text-arm-blue-900">View<span class="sr-only">, {{ $store->name }}</span></a>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-5">
                                    <div class="text-center">
                                        <h3 class="mt-2 text-sm font-semibold text-gray-900">No stores</h3>
                                        <p class="mt-1 text-sm text-gray-500">Get started by creating a new store.</p>
                                        <div class="mt-6">
                                            <button onclick="Livewire.emit('modal.open', 'dealer.store.create')" type="button" class="inline-flex items-center rounded-md bg-arm-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-arm-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-arm-blue-600">
                                                <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                                                </svg>
                                                Add Store
                                            </button>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
