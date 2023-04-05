<div class="w-full bg-white rounded-md shadow-sm shadow-gray-300">
    <div>
        <div class="inline-block min-w-full align-middle">
            <table class="min-w-full">
                <thead
                    class="text-xs font-semibold tracking-widest text-gray-600 uppercase border-t border-b border-gray-100 bg-gray-50">
                <tr>
                    <td class="px-4 py-4">Name</td>
                    <td class="px-4 py-4">Contact Name</td>
                    <td class="px-4 py-4">Contact Email</td>
                    <td class="px-4 py-4">Store</td>
                    <td class="px-4 py-4">Status</td>
                    <td class="px-4 py-4">No's</td>
                    <td class="px-4 py-4"></td>
                </tr>
                </thead>
                <tbody class="text-gray-700 whitespace-nowrap divide-y divide-gray-100">
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
