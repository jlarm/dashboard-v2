<div class="p-6">
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-xl font-bold leading-none tracking-tight text-neutral-900">Contracts</h1>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
            <div class="flex justify-end">
                <x-primary-link-button href="{{ route('contracts.create') }}">Create</x-primary-link-button>
            </div>
        </div>
    </div>
    <div class="mt-8">
        <x-table>
            <x-slot name="head">
                @can('delete-users')
                <x-table.heading>Id</x-table.heading>
                @endcan
                <x-table.heading>Dealership</x-table.heading>
                <x-table.heading>Status</x-table.heading>
                <x-table.heading></x-table.heading>
            </x-slot>
            <x-slot name="body">
                @foreach($contracts as $contract)
                    <livewire:central.contracts.index-item :contract="$contract" :key="$contract->id" />
                @endforeach
            </x-slot>
        </x-table>
    </div>
</div>
