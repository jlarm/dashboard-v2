<div class="w-full bg-white">
    <div>
        <div class="inline-block min-w-full align-middle">
            <table class="min-w-full divide-y divide-gray-300">
                <thead>
                <tr>
                    <th scope="col"
                        class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 lg:pl-8">Name
                    </th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Contact Name</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Contact Email</th>
                    @if(tenant('locations'))
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Store</th>
                    @endif
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">No's</th>
                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6 lg:pr-8"></th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                @forelse($vendors as $vendor)
                    <livewire:dealer.vendor.index-item :vendor="$vendor" :key="$vendor->id"/>
                @empty
                    <tr>
                        <td colspan="7"
                            class="px-4 py-4 text-center text-xl text-arm-blue-500 font-medium sm:pr-6 space-x-3">
                            No Vendors Added
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
