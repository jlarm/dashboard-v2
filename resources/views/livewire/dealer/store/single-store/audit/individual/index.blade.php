<div class="px-6">
    <div>
        <div class="py-5 sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-4xl font-bold text-arm-blue-900 sm:truncate leading-normal">Deal Jacket Audits</h1>
            </div>
            @can('create-audits')
            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                <a
                    class="inline-flex items-center px-4 py-2 bg-arm-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-arm-blue-700 focus:bg-arm-blue-700 active:bg-arm-blue-900 focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    href="{{ route('dealer.stores.audits.individual.create', $store) }}"
                >
                    Start New Quarterly Audit
                </a>
            </div>
            @endcan
        </div>
        <div class="border rounded-md">
            <div class="p-6 overflow-x-auto">
                <div class="inline-block min-w-full py-2 align-middle">
                    @can('create-audits')
                        <livewire:dealer.audit.individual.index :store="$store"/>
                    @endcan
                    @cannot('create-audits')
                        <livewire:dealer.audit.individual.generated-report-index :store="$store"/>
                    @endcannot
                </div>
            </div>
        </div>
    </div>
</div>
