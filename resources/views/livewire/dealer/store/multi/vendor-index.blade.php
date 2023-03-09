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
                    <td class="px-4 py-4">&nbsp;</td>
                    <td class="px-4 py-4"></td>
                </tr>
                </thead>
                <tbody class="text-gray-700 whitespace-nowrap divide-y divide-gray-100">
                @foreach($vendors as $vendor)
                    <livewire:dealer.store.multi.vendor-index-item :vendor="$vendor" :key="$vendor->id"/>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
