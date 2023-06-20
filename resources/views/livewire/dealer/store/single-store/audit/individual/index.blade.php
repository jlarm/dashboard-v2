<div>
    <livewire:dealer.store.single-store-sub-nav :store="$store"/>
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-lg font-medium leading-6 text-gray-900">Deal Jacket Audits</h1>
            </div>
            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                <a
                    class="inline-flex items-center px-4 py-2 bg-arm-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-arm-blue-700 focus:bg-arm-blue-700 active:bg-arm-blue-900 focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    href="{{ route('dealer.stores.audits.individual.create', $store) }}"
                >
                    Create Audit
                </a>
            </div>
        </div>
        <div class="mt-8 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle">
                    @can('create-audits')
                        <livewire:dealer.audit.individual.index :store="$store"/>
                    @endcan
                    @if(auth()->user()->cannot('create-audits'))
                        <livewire:dealer.audit.individual.generated-report-index/>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
