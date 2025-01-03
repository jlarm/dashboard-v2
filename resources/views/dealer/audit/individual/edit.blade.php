<x-dealer-app>
    <x-slot name="header">
        <x-slot name="pageTitle">Deal Jacket Audit for {{ $individualAudit->customer_name }}</x-slot>
    </x-slot>
    <div>
        <livewire:dealer.audit.individual.edit :individualAudit="$individualAudit"/>
    </div>
</x-dealer-app>
