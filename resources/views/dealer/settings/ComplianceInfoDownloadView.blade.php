<x-guest-layout>
    @include('dealer.settings.compliance-info', ['store' => $store, 'managers' => $store->employeeList])
</x-guest-layout>
