<div class="space-y-5">
    <div>
        <div class="flex items-center justify-between gap-x-6">
            <input type="search" name="search" id="search"
                   wire:model="search"
                   class="block w-full max-w-[300px] rounded-md border-gray-300 focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"
                   placeholder="Search Dealerships...">

            <div>
                <div class="w-[200px]">
                    <select wire:model="perPage" id="location" name="location" class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-8 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-1 focus:-outline-offset-1 focus:outline-arm-blue-600 sm:text-sm/6">
                        <option value="10">10 per page</option>
                        <option value="25">25 per page</option>
                        <option value="50">50 per page</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <x-table>
        <x-slot:head>
            <x-table.row>
                <x-table.heading>Name</x-table.heading>
                <x-table.heading>ID</x-table.heading>
                <x-table.heading>Consultants</x-table.heading>
                <x-table.heading></x-table.heading>
            </x-table.row>
        </x-slot:head>
        <x-slot:body>
            @foreach($dealerships as $dealership)
                <x-table.row :key="$dealership->id">
                    <x-table.cell>{{ $dealership->name }}</x-table.cell>
                    <x-table.cell>
                        <livewire:central.dealership.id-copy-field :dealership="$dealership" wire:key="id-copy-{{ $dealership->id }}" />
                    </x-table.cell>
                    <x-table.cell>
                        <livewire:central.dealership.consultant-avatars :dealership="$dealership" wire:key="avatars-{{ $dealership->id }}" />
                    </x-table.cell>
                    <x-table.cell align="end">
                        <x-armp.button
                            size="sm"
                            href="https://{{ $dealership->domain }}/dashboard"
                            target="_blank"
                            rel="noopener noreferrer"
                        >View</x-armp.button>
                    </x-table.cell>
                </x-table.row>
            @endforeach
        </x-slot:body>
    </x-table>

    <div>
        {{ $dealerships->links() }}
    </div>
</div>
