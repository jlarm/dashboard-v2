<x-dealer-app>
    <div
        class="px-6 py-5 sm:flex sm:items-center sm:justify-between">
        <div class="min-w-0 flex-1">
            <h1 class="text-4xl font-bold text-arm-blue-900 sm:truncate leading-normal">Deal Jacket Audit
                for {{ $individualAudit->customer_name }}</h1>
        </div>
    </div>

    <div>
        <livewire:dealer.audit.individual.edit :individualAudit="$individualAudit"/>
    </div>
</x-dealer-app>
