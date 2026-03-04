<x-dealer-app>
    <x-slot name="header">
        <x-slot:pageTitle>{{ __('Locations') }}</x-slot>
        <x-slot:actions>
            @hasanyrole('super-admin|Consultant')
            <x-armp.button variant="primary" size="sm" onclick="Livewire.emit('modal.open', 'tenant.location.create-modal')">Add Location</x-armp.button>
            @endhasanyrole
        </x-slot:actions>
    </x-slot>
    <div>
        <livewire:tenant.location.index />
    </div>
</x-dealer-app>
