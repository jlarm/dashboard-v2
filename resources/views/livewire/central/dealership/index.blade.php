<div class="space-y-5">
    <div class="md:w-1/4">
        <div>
            <label for="search" class="sr-only">Search</label>
            <input type="search" name="search" id="search"
                   wire:model="search"
                   class="block w-full rounded-md border-gray-300 focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"
                   placeholder="Search Dealerships...">
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
                    Consultant
                </th>
                @endrole
                <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell">
                    Dashboard
                </th>
                <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell">
                    Multiple Locations
                </th>
{{--                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">--}}
{{--                    <span class="sr-only">Edit</span>--}}
{{--                </th>--}}
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
            @forelse($dealerships as $dealership)
                <livewire:central.dealership.index-item :dealership="$dealership" :key="$dealership->id"/>
            @empty
                <tr>
                    <td class="py-4 pl-4 pr-3 text-center font-medium text-arm-blue-700 sm:pl-6" colspan="5">No
                        Dealerships
                        have been added.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
