<x-dealer-app>
    <div
        class="px-6 py-5 sm:flex sm:items-center sm:justify-between">
        <div class="min-w-0 flex-1">
            <h1 class="text-4xl font-bold text-arm-blue-900 sm:truncate leading-normal">Body Shop Audits</h1>
        </div>
        <div class="mt-4 flex sm:mt-0 sm:ml-4">
            @can('create-audits')
                <a
                    class="inline-flex items-center px-4 py-2 bg-arm-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-arm-blue-700 focus:bg-arm-blue-700 active:bg-arm-blue-900 focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    href="{{ route('dealer.audit.body-shop.create') }}"
                >
                    Create Audit
                </a>
            @endcan
        </div>
    </div>

    <div class="px-6">
        <div class="border rounded-md">
            <div class="p-6">
                @can('create-audits')
                    <livewire:dealer.audit.body-shop.index/>
                @endcan
                @if(auth()->user()->cannot('create-audits'))
                    <livewire:dealer.audit.body-shop.generated-report-index/>
                @endif
            </div>
        </div>
    </div>
</x-dealer-app>
