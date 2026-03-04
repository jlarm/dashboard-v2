<div class="space-y-6">
    <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
        <x-table>
            <x-slot name="head">
                <x-table.heading>Name</x-table.heading>
                <x-table.heading>City</x-table.heading>
                <x-table.heading>State</x-table.heading>
                <x-table.heading class="text-right">Actions</x-table.heading>
            </x-slot>

            <x-slot name="body">
                @forelse($this->stores as $store)
                    <x-table.row wire:key="location-store-{{ $store->id }}">
                        <x-table.cell>{{ $store->name }}</x-table.cell>
                        <x-table.cell>{{ $store->city ?: 'N/A' }}</x-table.cell>
                        <x-table.cell>{{ $store->state ?: 'N/A' }}</x-table.cell>
                        <x-table.cell class="text-right">
                            <button
                                type="button"
                                wire:click="openEditModal({{ $store->id }})"
                                class="text-sm font-medium text-arm-blue-600 hover:text-arm-blue-900"
                            >
                                Edit
                            </button>
                        </x-table.cell>
                    </x-table.row>
                @empty
                    <x-table.row>
                        <x-table.cell colspan="4">No locations found.</x-table.cell>
                    </x-table.row>
                @endforelse
            </x-slot>
        </x-table>
    </div>
</div>
