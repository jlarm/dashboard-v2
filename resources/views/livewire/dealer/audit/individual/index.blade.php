<div class="w-full bg-white">
    <div>
        <div class="inline-block min-w-full align-middle overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-300">
                <thead>
                <tr>
                    <th scope="col"
                        class="whitespace-nowrap py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Date
                    </th>
                    <th scope="col"
                        class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">Rating
                    </th>
                    @can('create-audits')
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"><span
                                class="sr-only">Edit</span></th>
                    @endcan
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                @forelse($audits as $individualAudit)
                    <livewire:dealer.audit.individual.index-item :store="$store" :individualAudit="$individualAudit"/>
                @empty
                    <tr>
                        <td colspan="7"
                            class="px-4 py-4 text-center text-xl text-arm-blue-500 font-medium sm:pr-6 space-x-3">
                            <div class="text-center">
                                <h3 class="mt-2 text-sm font-semibold text-gray-900">No audits</h3>
                                <p class="mt-1 text-sm text-gray-500">Get started by creating a new audit.</p>
                                <div class="mt-6">
                                    <a href="{{ $currentStore ? route('dealer.stores.audits.individual.create', $store) : route('dealer.audit.individual.create') }}" class="inline-flex items-center rounded-md bg-arm-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-arm-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-arm-blue-600">
                                        <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                                        </svg>
                                        Create Audit
                                    </a>
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
