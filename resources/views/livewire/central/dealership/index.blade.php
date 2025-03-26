<div class="space-y-5">
    <div class="">
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

    <div class="p-5 space-y-4 flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl">
        <x-table>
            <x-slot name="head">
                <x-table.row>
                    <x-table.heading>Name</x-table.heading>
                    @role('super-admin')<x-table.heading>Consultants</x-table.heading>@endrole
                    <x-table.heading>Dashboard</x-table.heading>
                    <x-table.heading></x-table.heading>
                </x-table.row>
            </x-slot>
            <x-slot name="body">
                @forelse($dealerships as $dealership)
                    <livewire:central.dealership.index-item :dealership="$dealership" :key="$dealership->id"/>
                @empty
                    <x-table.row>
                        <x-table.cell colspan="4" class="text-center">
                            No dealerships found.
                        </x-table.cell>
                    </x-table.row>
                @endforelse
            </x-slot>
        </x-table>
    </div>
    <div>
        {{ $dealerships->links() }}
    </div>
</div>
