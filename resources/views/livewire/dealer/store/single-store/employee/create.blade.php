<div>
    <x-slot name="header">
        <x-slot name="pageTitle">Create Employees</x-slot>
        <x-slot name="actions">
            <livewire:dealer.employee.sub-nav :store="$store" />
        </x-slot>
    </x-slot>
    <div>
        <livewire:dealer.employee.create :store="$store" />
    </div>
</div>
