<div class="w-full bg-white rounded-md shadow-sm shadow-gray-300">
    <div class="overflow-x-auto">
        <div class="inline-block min-w-full overflow-hidden align-middle">
            <table class="min-w-full divide-y divide-gray-200">
                <thead
                    class="text-xs font-semibold tracking-widest text-gray-600 uppercase border-t border-b border-gray-100 bg-gray-50">
                <tr>
                    <td class="px-4 py-4">Name</td>
                    <td class="px-4 py-4">Address</td>
                    <td class="px-4 py-4">Phone Number</td>
                    <td class="px-4 py-4">Website</td>
                    <td class="px-4 py-4"></td>
                </tr>
                </thead>
                <tbody class="text-gray-700 whitespace-nowrap divide-y divide-gray-100">
                @foreach($stores as $store)
                    <tr>
                        <td class="px-4 py-4">
                            <div class="flex space-x-4 w-max">
                                <div class="flex-1">
                                    <span class="text-sm font-semibold text-gray-800">{{ $store->name }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-700">
                            {{ $store->address }}<br/>
                            {{ $store->city }}, {{ $store->state }} {{ $store->postal_code }}
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-700">
                            {{ $store->phoneNumber }}
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-700">
                            {{ $store->website }}
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-700">
                            <a href="{{ route('dealer.stores.edit', $store) }}">Edit</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{ $stores->links() }}
</div>
