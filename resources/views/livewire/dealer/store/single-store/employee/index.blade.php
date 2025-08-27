<div>
    <x-slot name="header">
        <x-slot name="pageTitle">Employees</x-slot>
        <x-slot name="actions">
            <livewire:dealer.employee.sub-nav :store="$store" />
        </x-slot>
    </x-slot>
    <div class="sm:flex sm:items-center sm:justify-between">
        <div class="w-full flex items-center justify-between gap-x-3">
            <label>
                <input type="search" wire:model="search" placeholder="Search"
                       class="flex w-56 h-10 px-3 py-2 text-sm bg-white border rounded-md border-neutral-200 ring-offset-background placeholder:text-neutral-500 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50"/>
            </label>
            <div>
                <div
                    x-data="{
                        open: false,
                        toggle() {
                            if (this.open) {
                                return this.close()
                            }

                            this.$refs.button.focus()

                            this.open = true
                        },
                        close(focusAfter) {
                            if (! this.open) return

                            this.open = false

                            focusAfter && focusAfter.focus()
                        }
                    }"
                    x-on:keydown.escape.prevent.stop="close($refs.button)"
                    x-on:focusin.window="$refs.panel && !$refs.panel.contains($event.target) && close()"
                    x-id="['dropdown-button']"
                    class="relative"
                >
                    <!-- Button -->
                    <button
                        x-ref="button"
                        x-on:click="toggle()"
                        :aria-expanded="open"
                        :aria-controls="$id('dropdown-button')"
                        type="button"
                        class="flex items-center gap-2 bg-white px-2.5 py-2.5 rounded-md border border-b-neutral-200"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-400">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z"/>
                        </svg>
                    </button>

                    <!-- Panel -->
                    <div
                        x-ref="panel"
                        x-show="open"
                        x-transition.origin.top.left
                        x-on:click.outside="close($refs.button)"
                        :id="$id('dropdown-button')"
                        style="display: none;"
                        class="absolute right-0 mt-2 w-64 rounded-md bg-white shadow-md p-6 space-y-6 z-20"
                    >
                        <div class="w-full flex justify-between items-center">
                            <h4 class="text-base font-semibold leading-6 text-gray-950 dark:text-white">
                                Filters</h4>
                            <button
                                wire:click="resetFilters"
                                class="fi-link fi-link-size-md relative inline-flex items-center justify-center font-semibold outline-none transition duration-75 hover:underline focus:underline gap-1.5 text-sm text-red-600 dark:text-red-400">
                                Reset
                            </button>
                        </div>
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input wire:model="showIncompleteCourseUsers" name="custom-checkbox"
                                       id="custom-checkbox" type="checkbox" class="hidden peer"
                                       required>
                                <label for="custom-checkbox"
                                       class="peer-checked:[&_svg]:scale-100 text-sm font-medium text-neutral-600 peer-checked:text-arm-green-600 [&_svg]:scale-0 peer-checked:[&_.custom-checkbox]:border-arm-green-500 peer-checked:[&_.custom-checkbox]:bg-arm-green-500 select-none flex items-center space-x-2">
                            <span
                                class="flex items-center justify-center w-5 h-5 border-2 rounded custom-checkbox text-neutral-900">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="3"
                                     stroke="currentColor" class="w-3 h-3 text-white duration-300 ease-out">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                              </svg>
                            </span>
                                    <span>Incomplete Courses</span>
                                </label>
                            </div>
                        </div>
                        @if(auth()->user()->can('create-stores'))
                            <div>
                                <label for="department"
                                       class="text-sm font-medium leading-6 text-gray-950">Department</label>
                                <select wire:model="selectedDepartment" id="department" name="department"
                                        class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-arm-blue-600 sm:text-sm sm:leading-6">
                                    <option value="null">All</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="role"
                                       class="text-sm font-medium leading-6 text-gray-950">Role</label>
                                <select wire:model="selectedRole" id="role" name="role"
                                        class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-arm-blue-600 sm:text-sm sm:leading-6">
                                    <option value="null">All</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @can('create-dealerships')
                @if($showIncompleteCourseUsers && $selectedDepartment)
                    <div>
                        <form wire:submit.prevent="generateCsv" class="flex space-x-3">
                            <label>
                                <input type="email" wire:model.defer="email"
                                       placeholder="Enter Manager Email Address"
                                       class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md border-neutral-200 ring-offset-background placeholder:text-neutral-500 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50"/>
                            </label>
                            <x-primary-button>
                                <svg wire:loading class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Send
                            </x-primary-button>
                        </form>
                    </div>
                @endif
            @endcan
        </div>
    </div>
    <div class="mt-8 flow-root">
        <div>
            @if($selectedDepartmentName || $selectedRoleName || $showIncompleteCourseUsers)
                <div
                    class="flex items-start justify-between gap-x-3 py-1.5 border-b border-gray-200">
                    <div class="flex flex-col gap-x-3 gap-y-1 sm:flex-row">
                        <span
                            class="whitespace-nowrap text-sm font-medium leading-6 text-gray-700">Active Filters</span>
                        <div class="flex flex-wrap gap-1.5">
                            @if($showIncompleteCourseUsers)
                                <span
                                    class="inline-flex items-center gap-x-0.5 rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                              Incomplete Courses
                              <button wire:click="resetShowIncompleteCourseUsers" type="button"
                                      class="group relative -mr-1 h-3.5 w-3.5 rounded-sm hover:bg-blue-600/20">
                                <span class="sr-only">Remove</span>
                                <svg viewBox="0 0 14 14"
                                     class="h-3.5 w-3.5 stroke-blue-700/50 group-hover:stroke-blue-700/75">
                                  <path d="M4 4l6 6m0-6l-6 6"/>
                                </svg>
                                <span class="absolute -inset-1"></span>
                              </button>
                            </span>
                            @endif
                            @if($selectedDepartmentName)
                                <span
                                    class="inline-flex items-center gap-x-0.5 rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                          Department: {{ $selectedDepartmentName }}
                          <button wire:click="resetSelectedDepartment" type="button"
                                  class="group relative -mr-1 h-3.5 w-3.5 rounded-sm hover:bg-blue-600/20">
                            <span class="sr-only">Remove</span>
                            <svg viewBox="0 0 14 14"
                                 class="h-3.5 w-3.5 stroke-blue-700/50 group-hover:stroke-blue-700/75">
                              <path d="M4 4l6 6m0-6l-6 6"/>
                            </svg>
                            <span class="absolute -inset-1"></span>
                          </button>
                        </span>
                            @endif
                            @if($selectedRoleName)
                                <span
                                    class="inline-flex items-center gap-x-0.5 rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                          Role: {{ $selectedRoleName }}
                          <button wire:click="resetSelectedRole" type="button"
                                  class="group relative -mr-1 h-3.5 w-3.5 rounded-sm hover:bg-blue-600/20">
                            <span class="sr-only">Remove</span>
                            <svg viewBox="0 0 14 14"
                                 class="h-3.5 w-3.5 stroke-blue-700/50 group-hover:stroke-blue-700/75">
                              <path d="M4 4l6 6m0-6l-6 6"/>
                            </svg>
                            <span class="absolute -inset-1"></span>
                          </button>
                        </span>
                            @endif
                        </div>
                    </div>
                    <button wire:click="resetFilters">
                        <svg wire:loading.remove.delay="1" wire:target="removeTableFilters"
                             class="fi-icon-btn-icon h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 20 20"
                             fill="currentColor" aria-hidden="true">
                            <path
                                d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z"></path>
                        </svg>
                    </button>
                </div>
            @endif
            <div class="-mx-4 md:-mx-0 -my-2 md:-my-0 overflow-x-auto">
                <div class="inline-block min-w-full align-middle">
                    <x-table>
                        <x-slot name="head">
                            <x-table.row>
                                <x-table.cell>
                                    <button
                                        wire:click="sortBy('name')"
                                        class="flex items-center space-x-1 text-left font-semibold text-gray-900 hover:text-gray-700"
                                    >
                                        <span>Name</span>
                                        @if($sortField === 'name')
                                            @if($sortDirection === 'asc')
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                                </svg>
                                            @else
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                </svg>
                                            @endif
                                        @else
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                            </svg>
                                        @endif
                                    </button>
                                </x-table.cell>
                                <x-table.cell>Contact</x-table.cell>
                                <x-table.cell>
                                    <button
                                        wire:click="sortBy('role')"
                                        class="flex items-center space-x-1 text-left font-semibold text-gray-900 hover:text-gray-700"
                                    >
                                        <span>Role</span>
                                        @if($sortField === 'role')
                                            @if($sortDirection === 'asc')
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                                </svg>
                                            @else
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                </svg>
                                            @endif
                                        @else
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                            </svg>
                                        @endif
                                    </button>
                                </x-table.cell>
                                <x-table.cell>Store</x-table.cell>
                                <x-table.cell>
                                    <button
                                        wire:click="sortBy('department')"
                                        class="flex items-center space-x-1 text-left font-semibold text-gray-900 hover:text-gray-700"
                                    >
                                        <span>Department</span>
                                        @if($sortField === 'department')
                                            @if($sortDirection === 'asc')
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                                </svg>
                                            @else
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                </svg>
                                            @endif
                                        @else
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                            </svg>
                                        @endif
                                    </button>
                                </x-table.cell>
                                <x-table.cell>Courses</x-table.cell>
                                <x-table.cell></x-table.cell>
                            </x-table.row>
                        </x-slot>
                        <x-slot name="body">
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
                        </x-slot>
                    </x-table>
                </div>
            </div>
        </div>
    </div>
    @if(!$showIncompleteCourseUsers)
        <div class="mt-10">
            {{ $users->links() }}
        </div>
    @endif
</div>
