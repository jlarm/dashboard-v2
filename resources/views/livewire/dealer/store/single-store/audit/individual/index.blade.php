<div>
    <x-slot name="header">
        <x-slot name="pageTitle">Deal Jacket Audits</x-slot>
        <x-slot name="actions">
            @can('create-audits')
                <a class="inline-flex items-center px-4 py-2 bg-arm-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-arm-blue-700 focus:bg-arm-blue-700 active:bg-arm-blue-900 focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2 transition ease-in-out duration-150" href="{{ route('dealer.stores.audits.individual.create', $store) }}">
                    Start New Quarterly Audit
                </a>
            @endcan
        </x-slot>
    </x-slot>
    <div>
        @can('create-audits')
            <livewire:dealer.audit.individual.index :store="$store"/>
        @endcan
        @cannot('create-audits')
            <livewire:dealer.audit.individual.generated-report-index :store="$store"/>
        @endcannot
    </div>
</div>
