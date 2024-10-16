<div class="p-5">
    <x-table>
        <x-slot:head>
            <x-table.heading class="text-xs">Name</x-table.heading>
            <x-table.heading class="text-xs">Overall</x-table.heading>
            <x-table.heading class="text-xs">Deal Jackets</x-table.heading>
            <x-table.heading class="text-xs">OSHA</x-table.heading>
            <x-table.heading class="text-xs">GLBA</x-table.heading>
            <x-table.heading class="text-xs">Body Shop</x-table.heading>
            <x-table.heading class="text-xs"></x-table.heading>
        </x-slot:head>
        <x-slot:body>
            @forelse($stores as $store)
                <x-table.row class="hover:cursor-pointer" onclick="window.location='{{ route('dealer.stores.home', $store) }}'">
                    <x-table.cell>
                        {{ Str::limit($store->name, 20) }}
                    </x-table.cell>
                    <x-table.cell>
                        <x-grade-badge :grade="$store->overall_grade" >
                            {{ $store->overall_grade ?? '-' }}
                        </x-grade-badge>
                    </x-table.cell>
                    <x-table.cell>
                        <x-grade-badge :grade="$store->deal_jacket_grade" >
                            {{ $store->deal_jacket_grade ?? '-' }}
                        </x-grade-badge>
                    </x-table.cell>
                    <x-table.cell>
                        <x-grade-badge :grade="$store->osha_grade" >
                            {{ $store->osha_grade ?? '-' }}
                        </x-grade-badge>
                    </x-table.cell>
                    <x-table.cell>
                        <x-grade-badge :grade="$store->glba_grade" >
                            {{ $store->glba_grade ?? '-' }}
                        </x-grade-badge>
                    </x-table.cell>
                    <x-table.cell>
                        <x-grade-badge :grade="$store->body_shop_grade" >
                            {{ $store->body_shop_grade ?? '-' }}
                        </x-grade-badge>
                    </x-table.cell>
                    <x-table.cell>
                        <a href="{{ route('dealer.stores.home', $store) }}" class="text-arm-blue-600 hover:text-arm-blue-900">View<span class="sr-only">, {{ $store->name }}</span></a>
                    </x-table.cell>
                </x-table.row>
            @empty
                <x-table.row>
                    <td colspan="7" class="p-5">
                        <div class="text-center">
                            <h3 class="mt-2 text-sm font-semibold text-gray-900">No stores</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by creating a new store.</p>
                            <div class="mt-6">
                                <button onclick="Livewire.emit('modal.open', 'dealer.store.create')" type="button" class="inline-flex items-center rounded-md bg-arm-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-arm-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-arm-blue-600">
                                    Add Store
                                </button>
                            </div>
                        </div>

                    </td>
                </x-table.row>
            @endforelse
        </x-slot:body>
    </x-table>
    <div class="mt-5">
        {{ $stores->links() }}
    </div>
</div>
