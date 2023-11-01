<div class="flow-root">
    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
            <table class="min-w-full divide-y divide-gray-300">
                <thead>
                <tr>
                    <th scope="col"
                        class="whitespace-nowrap py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                        Name
                    </th>
                    <th scope="col"
                        class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">
                        Dashboard
                    </th>
                    <th scope="col"
                        class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">
                        Since
                    </th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                @forelse($dealerships as $dealership)
                    <tr>
                        <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm text-gray-900 sm:pl-0">{{ $dealership->name }}</td>
                        <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-900">{{ $dealership->domain }}</td>
                        <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-900">{{ $dealership->created_at->format('F d, Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="p-5 text-center">No assigned dealerships
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
