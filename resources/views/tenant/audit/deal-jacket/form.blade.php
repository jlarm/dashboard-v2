<x-dealer-app>
    <x-slot:header>
        <x-slot:pageTitle>{{ isset($dealJacket) && $dealJacket?->exists ? 'Edit' : 'Create new' }} Deal Jacket Audit</x-slot:pageTitle>
    </x-slot:header>
    <x-slot:actions>
        <x-button :href="route('dealer.audit.deal-jackets.show', $dealJacketGroup)" variant="ghost">
            <x-slot:icon>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
            </x-slot:icon>
            Back
        </x-button>
    </x-slot:actions>
    @if(isset($dealJacket) && $dealJacket?->exists)
        <livewire:tenant.audit.deal-jacket.form :dealJacketGroup="$dealJacketGroup" :dealJacket="$dealJacket" />
    @else
        <livewire:tenant.audit.deal-jacket.form :dealJacketGroup="$dealJacketGroup" />
    @endif
</x-dealer-app>
