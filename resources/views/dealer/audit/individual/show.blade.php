<x-dealer-app>
    <x-slot name="header">
        <x-slot name="pageTitle">
            Deal Jackets for {{ $individualAudit->quarter_name }} of {{ $individualAudit->audit_date->format('Y') }}
        </x-slot>
        <x-slot name="actions">
            <div class="flex items-center space-x-3">
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
        </x-slot>
    </x-slot>
    <div>
        <livewire:dealer.audit.individual.show :individualAudit="$individualAudit"/>
    </div>
</x-dealer-app>
