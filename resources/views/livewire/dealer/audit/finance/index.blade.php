<div class="w-full bg-white">
    <div>
        <div class="inline-block min-w-full align-middle">
            <table class="min-w-full divide-y divide-gray-300">
                <thead>
                <tr>
                    <th scope="col"
                        class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 lg:pl-8">Date
                    </th>
                    <th scope="col"
                        class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 lg:pl-8">Rating
                    </th>
                    @can('create-audits')
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"><span
                                class="sr-only">Edit</span></th>
                    @endcan
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                @forelse($financeAudits as $financeAudit)
                    <livewire:dealer.audit.finance.index-item :financeAudit="$financeAudit"/>
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
