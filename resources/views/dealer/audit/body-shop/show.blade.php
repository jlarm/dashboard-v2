<x-dealer-app>
    <div class="border-b border-gray-200 px-4 py-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
        <div class="min-w-0 flex-1">
            <h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">Body Shop Audit
                - {{ $bodyShopAudit->created_at->format('F d, Y') }}</h1>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <livewire:dealer.audit.body-shop.show :bodyShopAudit="$bodyShopAudit"/>
        </div>
    </div>
</x-dealer-app>
