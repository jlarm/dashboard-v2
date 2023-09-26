<x-dealer-app>
    <div
        class="bg-gray-50 border-b border-gray-200 px-4 py-5 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
        <div class="min-w-0 flex-1">
            <h1 class="text-4xl font-bold text-arm-blue-900 sm:truncate leading-normal">Deal Jacket Audits for
                {{ $individualAudit->audit_date->format('F d, Y') }}</h1>
        </div>
        <div class="mt-4 flex sm:mt-0 sm:ml-4 space-x-5">
            @if($individualAudit->pdf_path)
                <livewire:dealer.audit.individual.download :individualAudit="$individualAudit"/>
            @endif

            @if(!$individualAudit->pdf_path)
                <a class="inline-flex items-center px-4 py-2 bg-arm-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-arm-blue-700 focus:bg-arm-blue-700 active:bg-arm-blue-900 focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
                   href="{{ route('dealer.audit.individual.create', $individualAudit) }}">
                    Create Audit
                </a>
                <livewire:dealer.audit.individual.generate :individualAudit="$individualAudit"/>
            @endif
        </div>
    </div>

    <div class="py-12">
        <livewire:dealer.audit.individual.show :individualAudit="$individualAudit"/>
    </div>
</x-dealer-app>
