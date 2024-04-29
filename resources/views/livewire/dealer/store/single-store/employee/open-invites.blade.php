<div class="px-6">
    <div
        class="py-5 sm:flex sm:items-center sm:justify-between">
        <div class="min-w-0 flex-1">
            <h1 class="text-4xl font-bold text-arm-blue-900 sm:truncate">Open Invites</h1>
        </div>
        <a
            class="inline-flex items-center px-4 py-2 bg-arm-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-arm-blue-700 focus:bg-arm-blue-700 active:bg-arm-blue-900 focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
            href="{{ route('dealer.stores.employees', $store) }}"
        >
            Back to Employees
        </a>
    </div>
    <div class="border rounded-md">
        <div class="p-6">
            <div>
                <div class="md:w-1/3 px-3 sm:px-0 mb-5">
                    <div>
                        <label for="search" class="sr-only">Search</label>
                        <input type="search" name="search" id="search"
                               wire:model="search"
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"
                               placeholder="Search by Name...">
                    </div>
                </div>
                <div class="-mx-4 md:-mx-0 -my-2 md:-my-0 max-md:overflow-x-auto">
                    <div class="inline-block min-w-full py-2 align-middle">
                        <x-table>
                            <x-slot name="head">
                                <x-table.heading class="pl-4 pr-3">Name</x-table.heading>
                                <x-table.heading>Email</x-table.heading>
                                <x-table.heading>Original Invite Sent</x-table.heading>
                                <x-table.heading>Sent By</x-table.heading>
                                <x-table.heading></x-table.heading>
                            </x-slot>
                            <x-slot name="body">
                                @forelse($invites as $invite)
                                    <livewire:dealer.employee.open-invites-item :invite="$invite" :key="$invite->id"/>
                                @empty
                                    <x-table.row>
                                        <x-table.cell colspan="5" class="text-center text-xl text-arm-blue-500 font-medium">
                                            No Open Invites
                                        </x-table.cell>
                                    </x-table.row>
                                @endforelse
                            </x-slot>
                        </x-table>
                    </div>
                </div>
            </div>
            <div class="mt-10">
                {{ $invites->links() }}
            </div>
        </div>
    </div>

</div>
