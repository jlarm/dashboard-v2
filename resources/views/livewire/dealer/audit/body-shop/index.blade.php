<div class="w-full bg-white rounded-md shadow-sm shadow-gray-300">
    <div>
        <div class="inline-block min-w-full align-middle">
            <table class="min-w-full">
                <thead
                    class="text-xs font-semibold tracking-widest text-gray-600 uppercase border-t border-b border-gray-100 bg-gray-50">
                <tr>
                    <td class="px-4 py-4">Date</td>
                    <td class="px-4 py-4">Status</td>
                    <td class="px-4 py-4"></td>
                </tr>
                </thead>
                <tbody class="text-gray-700 whitespace-nowrap divide-y divide-gray-100">
                @forelse($audits as $audit)
                    <livewire:dealer.audit.body-shop.index-item :audit="$audit" :key="$audit->id"/>
                @empty
                    <tr>
                        <td colspan="7"
                            class="px-4 py-4 text-center text-xl text-arm-blue-500 font-medium sm:pr-6 space-x-3">
                            No Audits Created
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
