<x-dealer-app>
    <x-slot:header>
        <x-slot:pageTitle>Deal Jacket Audits</x-slot:pageTitle>
    </x-slot:header>
    <x-slot:actions>
        <div class="flex gap-2">
            <x-armp.button size="sm" :href="route('dealer.audit.individual.index')">View Past Audits</x-armp.button>
            @hasanyrole('super-admin|Consultant')
            <livewire:tenant.audit.deal-jacket.create-new-group-button />
            @endhasanyrole
        </div>
    </x-slot:actions>
    <div>
        @if (session()->has('message'))
            <x-modal-form name="audit-exists" :show="true">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Deal Jacket Audits</h3>
                    <p class="text-sm text-gray-600">{{ session('message') }}</p>
                    <div class="flex gap-2 mt-6">
                        <x-button class="w-full" @click="show = false">Cancel</x-button>
                        <x-button href="{{ route('dealer.audit.deal-jackets.show', session('dealJacketGroupUuid')) }}" class="w-full" variant="primary">View</x-button>
                    </div>
                </div>
            </x-modal-form>
        @endif
    </div>

    <div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <livewire:tenant.audit.deal-jacket.components.pass-rate-trend-chart />
            <livewire:tenant.audit.deal-jacket.components.common-issues-chart />
        </div>

        <livewire:tenant.audit.deal-jacket.group-index />
    </div>
</x-dealer-app>
