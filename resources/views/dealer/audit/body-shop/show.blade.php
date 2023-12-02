<x-dealer-app>
    <div
        class="px-6 py-5 sm:flex sm:items-center sm:justify-between">
        <div class="min-w-0 flex-1">
            <h1 class="text-4xl font-bold text-arm-blue-900 sm:truncate leading-normal">Body Shop Audit
                for {{ $bodyShopAudit->audit_date->format('F d, Y') }}</h1>
        </div>
    </div>

    <div>
        <livewire:dealer.audit.body-shop.show :bodyShopAudit="$bodyShopAudit"/>
    </div>
</x-dealer-app>
