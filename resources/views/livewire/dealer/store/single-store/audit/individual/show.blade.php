<div>
    <x-slot name="header">
        <x-slot name="pageTitle">Deal Jackets for {{ $this->getQuarterNameAttribute() }} of {{ $individualAudit->audit_date->format('Y') }}</x-slot>
        <x-slot name="actions">
            <div class="flex gap-2">
                @can('create-audits')
                    @if($individualAudit->pdf_path)
                        <livewire:dealer.audit.individual.download :individualAudit="$individualAudit"/>
                    @endif
                    @if(!$individualAudit->pdf_path)
                        <a
                            class="inline-flex items-center gap-x-1.5 rounded-md bg-arm-blue-600 px-2.5 py-1.5 text-sm text-white shadow-sm hover:bg-arm-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-arm-blue-600"
                            href="{{ route('dealer.stores.audits.individual.create', [$store, $individualAudit]) }}"
                        >
                            Create Audit
                        </a>
                        <livewire:dealer.audit.individual.generate :individualAudit="$individualAudit"/>
                    @endif
                @endcan
            </div>
        </x-slot>
    </x-slot>
    <div>
        <x-table>
            <x-slot name="head">
                <x-table.row>
                    <x-table.heading>Customer Number</x-table.heading>
                    <x-table.heading>Customer Name</x-table.heading>
                    <x-table.heading>Manager Name</x-table.heading>
                    <x-table.heading>Rating</x-table.heading>
                    <x-table.heading></x-table.heading>
                </x-table.row>
            </x-slot>
            <x-slot name="body">
                <livewire:dealer.store.single-store.audit.individual.parent-show-single :individualAudit="$individualAudit" :store="$store"/>
                @foreach($audits as $audit)
                    <livewire:dealer.audit.individual.show-single :individualAudit="$individualAudit" :store="$store" :audit="$audit"/>
                @endforeach
            </x-slot>
        </x-table>
    </div>
</div>
