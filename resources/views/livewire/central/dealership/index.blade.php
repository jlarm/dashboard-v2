<div class="space-y-5">
    <div class="">
        <div class="flex items-center justify-between gap-x-6">
            <input type="search" name="search" id="search"
                   wire:model="search"
                   class="block w-full rounded-md border-gray-300 focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"
                   placeholder="Search Dealerships...">

            <div>
                <div class="w-[200px]">
                    <select wire:model="perPage" id="location" name="location" class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-8 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-1 focus:-outline-offset-1 focus:outline-arm-blue-600 sm:text-sm/6">
                        <option value="1">1 per page</option>
                        <option value="10">10 per page</option>
                        <option value="25">25 per page</option>
                        <option value="50">50 per page</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="p-5 space-y-4 flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl">
        <table class="min-w-full divide-y divide-gray-300">
            <thead>
            <tr>
                <th scope="col" class="hidden py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell">
                    Name
                </th>
                @role('super-admin')
                <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell">
                    Consultants
                </th>
                @endrole
                <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell">
                    Dashboard
                </th>
                <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell">
                    Multiple Locations
                </th>
                @role('super-admin')
                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                    <span class="sr-only">Edit</span>
                </th>
                @endrole
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
            @forelse($dealerships as $dealership)
                <livewire:central.dealership.index-item :dealership="$dealership" :key="$dealership->id"/>
            @empty
                <tr>
                    <td class="py-4 pl-4 pr-3 text-center font-medium text-arm-blue-700 sm:pl-6" colspan="5">No Dealerships have been added.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div>
        {{ $dealerships->links() }}
    </div>
</div>
