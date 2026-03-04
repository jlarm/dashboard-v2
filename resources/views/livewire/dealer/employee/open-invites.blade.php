<div>
    <div>
        <div>
            <div class="w-full px-3 sm:px-0 mb-5 flex justify-between">
                <div class="flex gap-x-2">
                    <div>
                        <label for="search" class="sr-only">Search</label>
                        <input type="search" name="search" id="search"
                               wire:model="search"
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"
                               placeholder="Search by Name...">
                    </div>
                    @if(count($departmentIds) > 1)
                    <div>
                        <select wire:model="filterByDepartment" id="department" name="department" class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-8 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-1 focus:-outline-offset-1 focus:outline-arm-blue-600 sm:text-sm/6">
                            <option value="">Filter by Department</option>
                            @foreach($departmentIds as $id)
                                <option value="{{ $id }}">{{ $departmentNames[$id] ?? '' }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    @if($filterByDepartment || $search)
                        <x-secondary-button wire:click="clearFilters">Clear Filters</x-secondary-button>
                    @endif
                </div>
                @if(count($selected) > 1)
                    <div class="flex items-center">
                        <svg wire:loading wire:target="sendSelectedInvites" class="animate-spin -ml-1 mr-3 h-5 w-5 text-arm-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <x-primary-button class="bg-arm-green-500" wire:click="sendSelectedInvites">
                            <svg class="mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" color="#ffffff" fill="none">
                                <path d="M22 13.5V3.5H2V20.5H12" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                                <path d="M6 8L12 12L18 8" stroke="currentColor" stroke-width="1.5" />
                                <path d="M22 17.5L14.4245 17.5M17 20.5L14 17.5L17 14.5" stroke="currentColor" stroke-width="1.5" />
                            </svg>
                            Send Emails
                        </x-primary-button>
                    </div>
                @endif
            </div>
            <div class="-mx-4 md:-mx-0 -my-2 md:-my-0 max-md:overflow-x-auto">
                <div class="inline-block min-w-full py-2 align-middle">
                    <x-table>
                        <x-slot name="head">
                            <x-table.heading class="pl-4 pr-3">
                                <input wire:model="selectPage" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                            </x-table.heading>
                            <x-table.heading>Name</x-table.heading>
                            @if(app('multipleStoresExist'))
                                <x-table.heading>Store</x-table.heading>
                            @endif
                            <x-table.heading>Department</x-table.heading>
                            <x-table.heading>Email</x-table.heading>
                            <x-table.heading>Last Sent</x-table.heading>
                            <x-table.heading>Sent By</x-table.heading>
                            <x-table.heading></x-table.heading>
                        </x-slot>
                        <x-slot name="body">
                            @if($selectPage)
                            <x-table.row class="bg-gray-50" wire:key="row-message">
                                <x-table.cell></x-table.cell>
                                <x-table.cell class="pl-4" colspan="7">
                                    @if(!$selectAll && $invites->lastPage() > 1)
                                        <div>
                                            <span>You selected <strong>{{ $invites->count() }}</strong> invites. Do you want to select all <strong>{{ $invites->total() }}</strong>?</span>
                                            <button wire:click="selectAll" class="ml-1 text-arm-blue-500 hover:text-arm-blue-700">Select All</button>
                                        </div>
                                    @else
                                        <span>You are currently selecting all <strong>{{ $invites->total() }}</strong> invites.</span>
                                    @endunless
                                </x-table.cell>
                            </x-table.row>
                            @endif
                            @forelse($invites as $invite)
                                <x-table.row wire:key="row-{{ $invite->id }}">
                                    <x-table.cell>
                                        <input wire:model="selected" value="{{ $invite->id }}" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                                    </x-table.cell>
                                    <x-table.cell class="pl-4 pr-3">{{ Str::title($invite->name) }}</x-table.cell>
                                    @if(app('multipleStoresExist'))
                                        <x-table.cell class="pl-4 pr-3">
                                            {{ collect($invite->stores ?? [])->map(fn($id) => $storeNameMap[$id] ?? '')->filter()->implode(', ') }}
                                        </x-table.cell>
                                    @endif
                                    <x-table.cell class="pl-4 pr-3">{{ $departmentNames[$invite->department_id] ?? '' }}</x-table.cell>
                                    <x-table.cell>{{ Str::lower($invite->email) }}</x-table.cell>
                                    <x-table.cell>{{ $invite->updated_at->format('F d, Y') }}</x-table.cell>
                                    <x-table.cell>{{ $invite->user->name }}</x-table.cell>
                                    <x-table.cell class="flex justify-end gap-3">
                                        <div class="relative">
                                            <svg wire:loading wire:target="sendInvite({{ $invite->id }})" class="absolute top-1 -left-3 animate-spin -ml-1 mr-3 h-3 w-3 text-arm-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            <button wire:click="sendInvite({{ $invite->id }})">Resend Invite</button>
                                        </div>
                                        <button
                                            class="text-red-500"
                                            wire:click="$emit('modal.open', 'dealer.employee.delete-invite', @js(['inviteId' => $invite->id]))"
                                        >
                                            Delete
                                        </button>
                                    </x-table.cell>
                                </x-table.row>

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
