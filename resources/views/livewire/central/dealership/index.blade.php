<div class="space-y-5">
    <div class="w-1/4">
        <div>
            <label for="search" class="sr-only">Email</label>
            <input type="search" name="search" id="search"
                   wire:model="search"
                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"
                   placeholder="Search Dealerships...">
        </div>
    </div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border">
        <table class="min-w-full divide-y divide-gray-300">
            <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Name</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Consultant</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Dashboard</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Multiple Locations
                </th>
                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                    <span class="sr-only">Edit</span>
                </th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
            @forelse($dealerships as $dealership)
                <tr>
                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                        {{ $dealership->name }}
                        @role('super-admin')
                        <span class="block font-light text-gray-400">{{ $dealership->id }}</span>
                        @endrole
                    </td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $dealership->user->name }}</td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 hover:text-gray-400">
                        <a class="flex items-center space-y-3" target="_blank"
                           href="https://{{ $dealership->domain }}/dashboard">
                            {{ $dealership->domain }}
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="w-3 h-3">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
                            </svg>
                        </a>
                    </td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                <span
                    class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800">
                    {{ $dealership->locations ? 'Yes' : 'No' }}
                </span>
                    </td>
                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium text-arm-blue-600 sm:pr-6 space-x-5">
                        <button
                            wire:click="$emit('slide-over.open', 'central.dealership.edit', @js(['dealership' => $dealership->id]))">
                            Edit
                        </button>
                    </td>
                </tr>
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
