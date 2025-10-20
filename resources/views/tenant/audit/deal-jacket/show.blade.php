<x-dealer-app>
    <x-slot:header>
        <x-slot:pageTitle>Deal Jackets for Quarter {{ $dealJacketGroup->created_at->quarter }} of {{ $dealJacketGroup->created_at->year }}</x-slot:pageTitle>
    </x-slot:header>
    <x-slot:actions>
        @hasanyrole('super-admin|Consultant')
        <x-button href="{{ route('dealer.audit.deal-jackets.create', $dealJacketGroup) }}" variant="primary">Add Deal Jacket</x-button>
        @endhasanyrole
        <x-button :href="route('dealer.audit.deal-jackets.index')">Back</x-button>
    </x-slot:actions>
    <div>
        <livewire:tenant.audit.deal-jacket.deal-jacket-index :dealJacketGroup="$dealJacketGroup" />
    </div>
</x-dealer-app>
