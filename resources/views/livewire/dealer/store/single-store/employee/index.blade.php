<div>
    <div>
        <livewire:dealer.store.single-store-sub-nav :store="$store"/>
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="sm:flex sm:items-center sm:justify-between">
                <div class="w-full max-w-xs flex gap-x-3">
                    <label>
                        <input type="search" wire:model="search" placeholder="Search"
                               class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md border-neutral-200 ring-offset-background placeholder:text-neutral-500 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50"/>
                    </label>
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
                    @if($showIncompleteCourses)
                        <a
                            wire:click="hideIncompleteCourses"
                            class="hover:cursor-pointer inline-flex items-center gap-x-0.5 rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">
                            Clear
                            <button type="button"
                                    class="group relative -mr-1 h-3.5 w-3.5 rounded-sm">
                                <span class="sr-only">Remove</span>
                                <svg viewBox="0 0 14 14"
                                     class="h-3.5 w-3.5 stroke-gray-600/50 group-hover:stroke-gray-600/75">
                                    <path d="M4 4l6 6m0-6l-6 6"/>
                                </svg>
                                <span class="absolute -inset-1"></span>
                            </button>
                        </a>
                    @endif
                </div>
                <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                    <x-primary-button onclick="Livewire.emit('modal.open', 'dealer.employee.invite')">Add Employee
                    </x-primary-button>
                </div>
            </div>
            <div class="mt-8 flow-root">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead>
                            <tr>
                                <th scope="col"
                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 lg:pl-8">
                                    Name
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Contact
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Role
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Store
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Department
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Courses
                                </th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6 lg:pr-8">
                                    <span class="sr-only">Edit</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse($users as $user)
                                <livewire:dealer.store.single-store.employee.index-item :user="$user" :key="$user->id"/>
                            @empty
                                <tr>
                                    <td colspan="7"
                                        class="px-4 py-4 text-center text-xl text-arm-blue-500 font-medium sm:pr-6 space-x-3">
                                        No Employees
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @if(!$showIncompleteCourses)
                <div class="mt-10">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
