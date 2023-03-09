<x-store-app :title="$store->name">
    <div class="mb-5 flex justify-end">
        <x-primary-button onclick="Livewire.emit('modal.open', 'dealer.employee.invite')">Add Employee
        </x-primary-button>
    </div>
    <livewire:dealer.store.multi.employee-index :store="$store"/>
</x-store-app>
