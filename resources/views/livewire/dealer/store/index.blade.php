<div class="-mx-4 overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:-mx-6 md:mx-0 md:rounded-lg">
    <table class="min-w-full divide-y divide-gray-300">
        <thead class="bg-gray-50">
        <tr>
            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Name</th>
            <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell">Address</th>
            <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell">Phone Number</th>
            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Website</th>
            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                <span class="sr-only">Edit</span>
            </th>
        </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 bg-white">
        @foreach($stores as $store)
            <tr>
                <td class="w-full max-w-0 py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:w-auto sm:max-w-none sm:pl-6">
                    {{ $store->name }}
                    <dl class="font-normal lg:hidden">
                        <dt class="sr-only">{{ $store->name }}</dt>
                        <dd class="mt-1 truncate text-gray-700">
                            {{ $store->address }}
                        </dd>
                        <dt class="sr-only sm:hidden">Email</dt>
                        <dd class="mt-1 truncate text-gray-500 sm:hidden">lindsay.walton@example.com</dd>
                    </dl>
                </td>
                <td class="hidden px-3 py-4 text-sm text-gray-500 lg:table-cell">
                    {{ $store->address }}<br />
                    {{ $store->city }}, {{ $store->state }} {{ $store->postal_code }}
                </td>
                <td class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell">{{ $store->phone }}</td>
                <td class="px-3 py-4 text-sm text-gray-500">{{ $store->website }}</td>
                <td class="py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                    <a href="{{ route('dealer.stores.show', $store) }}">View</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $stores->links() }}
</div>
