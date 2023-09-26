<x-dealer-app>
    <div
        class="bg-gray-50 border-b border-gray-200 px-4 py-5 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
        <div class="min-w-0 flex-1">
            <h1 class="text-4xl font-bold text-arm-blue-900 sm:truncate leading-normal">Body Shop Audit
                for {{ $bodyShopAudit->audit_date->format('F d, Y') }}</h1>
        </div>
    </div>

    <div class="py-12">
        <livewire:dealer.audit.body-shop.show :bodyShopAudit="$bodyShopAudit"/>
    </div>
</x-dealer-app>
