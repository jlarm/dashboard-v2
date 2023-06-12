<x-dealer-app>
    <div
        class="bg-gray-50 border-b border-gray-200 px-4 py-20 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
        <div class="min-w-0 flex-1">
            <h1 class="text-4xl font-bold text-arm-blue-900 sm:truncate">Deal Jacket Audit
                for {{ $individualAudit->customer_name }}</h1>
        </div>
    </div>

    <div class="py-12">
        <livewire:dealer.audit.individual.edit :individualAudit="$individualAudit"/>
    </div>
</x-dealer-app>
