<div>
    <div>
        <div class="mb-4">
            <div class="w-full flex justify-between items-center mx-auto">
                <label>
                    <input
                        type="search"
                        wire:model="search"
                        placeholder="Search"
                        class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md border-neutral-200 ring-offset-background placeholder:text-neutral-500 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50"
                    />
                </label>
                <div class="flex items-center space-x-3">
                    @if(count($selectedUsers) > 0)
                        <button
                            wire:click="exportCsv"
                            class="inline-flex items-center gap-2 bg-arm-blue-600 hover:bg-arm-blue-500 px-4 py-2 rounded-md text-white text-sm font-semibold transition-colors"
                        >
                            <svg
                                wire:loading
                                wire:target="exportCsv"
                                class="animate-spin h-4 w-4"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                            >
                                <circle
                                    class="opacity-25"
                                    cx="12"
                                    cy="12"
                                    r="10"
                                    stroke="currentColor"
                                    stroke-width="4"
                                ></circle>
                                <path
                                    class="opacity-75"
                                    fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                ></path>
                            </svg>
                            <svg
                                wire:loading.remove
                                wire:target="exportCsv"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="w-4 h-4"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"
                                />
                            </svg>
                            Export CSV ({{ count($selectedUsers) }})
                        </button>
                    @endif
                    @can('create-dealerships')
                        @if($showIncompleteCourseUsers && $selectedDepartment)
                            <div>
                                <form wire:submit.prevent="generateCsv" class="flex space-x-3">
                                    <label>
                                        <input
                                            type="email"
                                            wire:model.defer="email"
                                            placeholder="Enter Manager Email Address"
                                            class="flex w-56 h-10 px-3 py-2 text-sm bg-white border rounded-md border-neutral-200 ring-offset-background placeholder:text-neutral-500 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50"
                                        />
                                    </label>
                                    <x-primary-button>
                                        <svg
                                            wire:loading
                                            class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                        >
                                            <circle
                                                class="opacity-25"
                                                cx="12"
                                                cy="12"
                                                r="10"
                                                stroke="currentColor"
                                                stroke-width="4"
                                            ></circle>
                                            <path
                                                class="opacity-75"
                                                fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                            ></path>
                                        </svg>
                                        Send
                                    </x-primary-button>
                                </form>
                            </div>
                        @endif
                    @endcan
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
                        <button
                            x-ref="button"
                            x-on:click="toggle()"
                            :aria-expanded="open"
                            :aria-controls="$id('dropdown-button')"
                            type="button"
                            class="flex items-center gap-2 bg-white px-2.5 py-2.5 rounded-md border border-b-neutral-200"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="w-5 h-5 text-gray-400"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z"
                                />
                            </svg>
                        </button>

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
                                <h4 class="text-base font-semibold leading-6 text-gray-950">
                                    Filters
                                </h4>
                                <button
                                    wire:click="resetFilters"
                                    class="fi-link fi-link-size-md relative inline-flex items-center justify-center font-semibold outline-none transition duration-75 hover:underline focus:underline gap-1.5 text-sm text-red-600"
                                >
                                    Reset
                                </button>
                            </div>
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input
                                        wire:model="showIncompleteCourseUsers"
                                        name="custom-checkbox"
                                        id="custom-checkbox"
                                        type="checkbox"
                                        class="hidden peer"
                                        required
                                    >
                                    <label
                                        for="custom-checkbox"
                                        class="peer-checked:[&_svg]:scale-100 text-sm font-medium text-neutral-600 peer-checked:text-arm-green-600 [&_svg]:scale-0 peer-checked:[&_.custom-checkbox]:border-arm-green-500 peer-checked:[&_.custom-checkbox]:bg-arm-green-500 select-none flex items-center space-x-2"
                                    >
                                        <span class="flex items-center justify-center w-5 h-5 border-2 rounded custom-checkbox text-neutral-900">
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke-width="3"
                                                stroke="currentColor"
                                                class="w-3 h-3 text-white duration-300 ease-out"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M4.5 12.75l6 6 9-13.5"
                                                />
                                            </svg>
                                        </span>
                                        <span>Incomplete Courses</span>
                                    </label>
                                </div>
                            </div>
                            @can('create-stores')
                                <div>
                                    <label
                                        for="department"
                                        class="text-sm font-medium leading-6 text-gray-950"
                                    >
                                        Department
                                    </label>
                                    <select
                                        wire:model="selectedDepartment"
                                        id="department"
                                        name="department"
                                        class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-arm-blue-600 sm:text-sm sm:leading-6"
                                    >
                                        <option value="null">All</option>
                                        @foreach($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label
                                        for="role"
                                        class="text-sm font-medium leading-6 text-gray-950"
                                    >
                                        Role
                                    </label>
                                    <select
                                        wire:model="selectedRole"
                                        id="role"
                                        name="role"
                                        class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-arm-blue-600 sm:text-sm sm:leading-6"
                                    >
                                        <option value="null">All</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-8 flow-root">
                <div>
                    @if($selectedDepartmentName || $selectedRoleName || $showIncompleteCourseUsers)
                        <div class="flex items-start justify-between gap-x-3 px-4 py-1.5 sm:px-8 bg-gray-50 border-y border-gray-200">
                            <div class="flex flex-col gap-x-3 gap-y-1 sm:flex-row">
                                <span class="whitespace-nowrap text-sm font-medium leading-6 text-gray-700">
                                    Active Filters
                                </span>
                                <div class="flex flex-wrap gap-1.5">
                                    @if($showIncompleteCourseUsers)
                                        <span class="inline-flex items-center gap-x-0.5 rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                                            Incomplete Courses
                                            <button
                                                wire:click="resetShowIncompleteCourseUsers"
                                                type="button"
                                                class="group relative -mr-1 h-3.5 w-3.5 rounded-sm hover:bg-blue-600/20"
                                            >
                                                <span class="sr-only">Remove</span>
                                                <svg
                                                    viewBox="0 0 14 14"
                                                    class="h-3.5 w-3.5 stroke-blue-700/50 group-hover:stroke-blue-700/75"
                                                >
                                                    <path d="M4 4l6 6m0-6l-6 6" />
                                                </svg>
                                                <span class="absolute -inset-1"></span>
                                            </button>
                                        </span>
                                    @endif
                                    @if($selectedDepartmentName)
                                        <span class="inline-flex items-center gap-x-0.5 rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                                            Department: {{ $selectedDepartmentName }}
                                            <button
                                                wire:click="resetSelectedDepartment"
                                                type="button"
                                                class="group relative -mr-1 h-3.5 w-3.5 rounded-sm hover:bg-blue-600/20"
                                            >
                                                <span class="sr-only">Remove</span>
                                                <svg
                                                    viewBox="0 0 14 14"
                                                    class="h-3.5 w-3.5 stroke-blue-700/50 group-hover:stroke-blue-700/75"
                                                >
                                                    <path d="M4 4l6 6m0-6l-6 6" />
                                                </svg>
                                                <span class="absolute -inset-1"></span>
                                            </button>
                                        </span>
                                    @endif
                                    @if($selectedRoleName)
                                        <span class="inline-flex items-center gap-x-0.5 rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                                            Role: {{ $selectedRoleName }}
                                            <button
                                                wire:click="resetSelectedRole"
                                                type="button"
                                                class="group relative -mr-1 h-3.5 w-3.5 rounded-sm hover:bg-blue-600/20"
                                            >
                                                <span class="sr-only">Remove</span>
                                                <svg
                                                    viewBox="0 0 14 14"
                                                    class="h-3.5 w-3.5 stroke-blue-700/50 group-hover:stroke-blue-700/75"
                                                >
                                                    <path d="M4 4l6 6m0-6l-6 6" />
                                                </svg>
                                                <span class="absolute -inset-1"></span>
                                            </button>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <button wire:click="resetFilters">
                                <svg
                                    wire:loading.remove.delay="1"
                                    wire:target="removeTableFilters"
                                    class="fi-icon-btn-icon h-5 w-5 text-gray-400"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                    aria-hidden="true"
                                >
                                    <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                                </svg>
                            </button>
                        </div>
                    @endif
                    <div class="-mx-4 md:-mx-0 -my-2 md:-my-0 overflow-x-auto">
                        <div class="inline-block min-w-full align-middle">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead>
                                    <tr>
                                        <th scope="col" class="whitespace-nowrap py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900">
                                            <input
                                                type="checkbox"
                                                wire:click.prevent="toggleSelectAll"
                                                {{ $selectAll ? 'checked' : '' }}
                                                class="h-4 w-4 ml-1 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600 cursor-pointer"
                                            />
                                        </th>
                                        <th
                                            scope="col"
                                            class="whitespace-nowrap py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900"
                                        >
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
                                        </th>
                                        <th
                                            scope="col"
                                            class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900"
                                        >
                                            Contact
                                        </th>
                                        @if(tenant('locations'))
                                            <th
                                                scope="col"
                                                class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900"
                                            >
                                                Store(s)
                                            </th>
                                        @endif
                                        <th
                                            scope="col"
                                            class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900"
                                        >
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
                                        </th>
                                        <th
                                            scope="col"
                                            class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900"
                                        >
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
                                        </th>
                                        <th
                                            scope="col"
                                            class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900"
                                        >
                                            Courses
                                        </th>
                                        <th
                                            scope="col"
                                            class="relative py-3.5 pl-3 pr-4 sm:pr-6 lg:pr-8"
                                        >
                                            <span class="sr-only">View</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    @forelse($users as $user)
                                        <tr class="even:bg-gray-50" wire:key="user-{{ $user->id }}">
                                            <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm text-gray-500">
                                                <input
                                                    type="checkbox"
                                                    wire:click="toggleUserSelection({{ $user->id }})"
                                                    @if(in_array($user->id, $selectedUsers)) checked @endif
                                                    class="h-4 w-4 ml-1 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600 cursor-pointer"
                                                />
                                            </td>
                                            <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm text-gray-500">
                                                {{ Str::headline($user->name) }}
                                            </td>
                                            <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-900">
                                                <div><a href="mailto:{{ $user->email }}">{{ Str::lower($user->email) }}</a></div>
                                            </td>
                                            @if(tenant('locations'))
                                                <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-900">
                                                    @foreach($user->stores as $store)
                                                        <div class="flex flex-col">
                                                            <span>{{ $store->name }}</span>
                                                        </div>
                                                    @endforeach
                                                </td>
                                            @endif
                                            <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-900">
                                                {{ $user->department->name ?? '' }}
                                            </td>
                                            <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-900">
                                                @foreach($user->roles as $role)
                                                    @if($role->name === 'Manager')
                                                        <span class="inline-flex items-center rounded-md bg-arm-blue-50 px-2 py-1 text-xs font-medium text-arm-blue-700 ring-1 ring-inset ring-arm-blue-700/10">{{ $role->name }}</span>
                                                    @elseif($role->name === 'Employee')
                                                        <span class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">{{ $role->name }}</span>
                                                    @elseif($role->name === 'Consultant')
                                                        <span class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">{{ $role->name }}</span>
                                                    @else
                                                        <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">{{ $role->name }}</span>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-900">
                                                @if($user->total_completed_courses === $user->total_user_courses)
                                                    <span class="inline-flex items-center rounded-md bg-green-100 px-2 py-1 text-xs font-medium text-green-700">Completed</span>
                                                @else
                                                    {{ $user->total_completed_courses }} of {{ $user->total_user_courses }}
                                                @endif
                                            </td>
                                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 flex justify-end text-sm font-medium sm:pr-6 lg:pr-8">
                                                @if(auth()->user()->id !== $user->id && !$user->hasRole('Consultant'))
                                                    <a href="{{ route('dealer.employees.show', $user) }}" class="text-sm text-arm-blue-500 hover:text-arm-blue-700">View</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td
                                                colspan="7"
                                                class="px-4 py-4 text-center text-xl text-arm-blue-500 font-medium sm:pr-6 space-x-3"
                                            >
                                                <div class="text-center">
                                                    <h3 class="mt-2 text-sm font-semibold text-gray-900">
                                                        No employees
                                                    </h3>
                                                    <p class="mt-1 text-sm text-gray-500">
                                                        Get started by creating a new employee.
                                                    </p>
                                                    <div class="mt-6">
                                                        <a
                                                            href="{{ route('dealer.employees.new') }}"
                                                            type="button"
                                                            class="inline-flex items-center rounded-md bg-arm-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-arm-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-arm-blue-600"
                                                        >
                                                            <svg
                                                                class="-ml-0.5 mr-1.5 h-5 w-5"
                                                                viewBox="0 0 20 20"
                                                                fill="currentColor"
                                                                aria-hidden="true"
                                                            >
                                                                <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                                                            </svg>
                                                            Add Employee
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-10">
                @if(!$showIncompleteCourseUsers)
                    {{ $users->links() }}
                @endif
            </div>
        </div>
    </div>
</div>
