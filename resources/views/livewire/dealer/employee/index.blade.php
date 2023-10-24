<div>
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="mb-4">
            <div class="flex justify-between items-center">
                <div class="-ml-4 flex items-center gap-x-3">
                    <div class="w-full max-w-xs mx-auto">
                        <label>
                            <input type="search" wire:model="search" placeholder="Search"
                                   class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md border-neutral-200 ring-offset-background placeholder:text-neutral-500 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50"/>
                        </label>
                    </div>
                    @can('delete-stores')
                        <div x-data="{
                            dropdownOpen: false
                        }"
                             class="relative">

                            <button @click="dropdownOpen=true"
                                    class="inline-flex items-center justify-center h-10 px-4 py-2 text-sm font-medium transition-colors bg-white border rounded-md hover:bg-neutral-100 active:bg-white focus:bg-white focus:outline-none focus:ring-2 focus:ring-neutral-200/60 focus:ring-offset-2 disabled:opacity-50 disabled:pointer-events-none">
                                Filter
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5"
                                     stroke="currentColor" class="w-4 h-4 ml-1">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z"/>
                                </svg>

                            </button>

                            <div x-show="dropdownOpen"
                                 @click.away="dropdownOpen=false"
                                 x-transition:enter="ease-out duration-200"
                                 x-transition:enter-start="-translate-y-2"
                                 x-transition:enter-end="translate-y-0"
                                 class="absolute top-0 z-50 w-56 mt-12 -translate-x-1/2 left-1/2"
                                 x-cloak>
                                <div
                                    class="p-1 mt-1 text-sm bg-white border rounded-md shadow-md border-neutral-200/70 text-neutral-700">
                                    <div
                                        class="relative flex cursor-default select-none items-center rounded py-1.5 pl-3 hover:bg-neutral-100 outline-none data-[disabled]:opacity-50 space-x-2">
                                        <input
                                            type="checkbox"
                                            id="incompleteCourses"
                                            wire:model="showIncompleteCourses"
                                            class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-arm-blue-600 focus:ring-arm-blue-600"
                                        >
                                        <label for="incompleteCourses">Incomplete Courses</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endcan
                </div>
                <div class="flex flex-row-reverse">
                    @can('delete-stores')
                        @if (count($selected) > 0)
                            <x-primary-button wire:click="exportCsv" class="mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5"
                                     stroke="currentColor" class="w-4 h-4 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>
                                </svg>
                                Export
                            </x-primary-button>
                        @endif
                    @endcan
                </div>
            </div>
        </div>
        <div class="mt-8 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead>
                        <tr>
                            @can('delete-stores')
                                <th scope="col" class="relative px-7 sm:w-12 sm:px-6">
                                    <input
                                        wire:model="selectPage"
                                        type="checkbox"
                                        class="absolute left-4 top-1/2 -mt-2 h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                                    >
                                </th>
                            @endcan
                            <th scope="col"
                                class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 lg:pl-8">
                                Name
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Contact
                            </th>
                            @if(tenant('locations'))
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Store(s)
                                </th>
                            @endif
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                Department
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Role</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Completed
                                Courses
                            </th>
                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6 lg:pr-8">
                                <span class="sr-only">View</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                        @if ($selectPage)
                            <tr class="bg-gray-100" wire:key="row-message">
                                <td colspan="7"
                                    class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8">
                                    @unless($selectAll)
                                        <div>
                                            <span>You selected <strong>{{ $users->count() }}</strong> employees, do you want to
                                        select
                                        all
                                        <strong></strong>?</span>
                                            <button wire:click="selectAll" class="text-arm-blue-500 ml-3">Select All
                                            </button>
                                        </div>
                                    @else
                                        <span>You are currently selecting all <strong></strong>
                                        employees.</span>
                                    @endunless
                                </td>
                            </tr>
                        @endif
                        @forelse($users as $user)
                            <tr wire:key="user-{{ $user->id }}" class="odd:bg-gray-50 hover:bg-arm-blue-50">
                                @can('delete-stores')
                                    <td class="relative px-7 sm:w-12 sm:px-6">
                                        <input
                                            wire:model="selected"
                                            type="checkbox"
                                            class="absolute left-4 top-1/2 -mt-2 h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                                            value="{{ $user->id }}"
                                        >
                                    </td>
                                @endcan
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8">
                                    {{ $user->name }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    <div><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></div>
                                </td>
                                @if(tenant('locations'))
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        @foreach($user->stores as $store)
                                            <div class="flex flex-col">
                                                <span>{{ $store->name }}</span>
                                            </div>
                                        @endforeach
                                    </td>
                                @endif
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    {{ $user->department->name ?? '' }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    @foreach($user->roles as $role)
                                        @if($role->name == 'Manager')
                                            <span
                                                class="inline-flex items-center rounded-md bg-arm-blue-50 px-2 py-1 text-xs font-medium text-arm-blue-700 ring-1 ring-inset ring-arm-blue-700/10">{{ $role->name }}</span>
                                        @elseif($role->name == 'Employee')
                                            <span
                                                class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">{{ $role->name }}</span>
                                        @elseif($role->name == 'Consultant')
                                            <span
                                                class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">{{ $role->name }}</span>
                                        @else
                                            <span
                                                class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">{{ $role->name }}</span>
                                        @endif
                                    @endforeach
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    {{ $user->total_completed_courses }} of {{ $user->total_user_courses }} passed
                                </td>
                                <td class="relative whitespace-nowrap py-4 pl-3 pr-4 flex justify-end text-sm font-medium sm:pr-6 lg:pr-8">
                                    @if(!$user->hasRole('Consultant'))
                                        <a href="{{ route('dealer.employees.show', $user) }}"
                                           class="text-sm text-arm-blue-500 hover:text-arm-blue-700">View</a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7"
                                    class="px-4 py-4 text-center text-xl text-arm-blue-500 font-medium sm:pr-6 space-x-3">
                                    No Employees Created
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="mt-10">
            {{ $users->links() }}
        </div>
    </div>
</div>
