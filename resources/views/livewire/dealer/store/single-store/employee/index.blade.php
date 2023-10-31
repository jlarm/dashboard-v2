<div>
    <div>
        <livewire:dealer.store.single-store-sub-nav :store="$store"/>
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="sm:flex sm:items-center sm:justify-between">
                <div class="w-full max-w-xs flex items-center gap-x-3">
                    <label>
                        <input type="search" wire:model="search" placeholder="Search"
                               class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md border-neutral-200 ring-offset-background placeholder:text-neutral-500 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50"/>
                    </label>
                    <div class="w-full max-w-xs">
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
                    </div>
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
            @if(!$showIncompleteCourseUsers)
                <div class="mt-10">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
