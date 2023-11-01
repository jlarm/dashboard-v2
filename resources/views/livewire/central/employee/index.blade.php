<div class="bg-white rounded-md p-6">
    <div>
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-xl font-bold leading-none tracking-tight text-neutral-900">Employees</h1>
            </div>
            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                <div class="flex justify-end">
                    <x-primary-button onclick="Livewire.emit('modal.open', 'central.employee.invite')">Invite Employee
                    </x-primary-button>
                    <div class="ml-5">
                        <div>
                            <label for="search" class="sr-only">Email</label>
                            <input type="search" name="search" id="search"
                                   wire:model="search"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"
                                   placeholder="Search Employees...">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-8 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead>
                        <tr>
                            <th scope="col"
                                class="whitespace-nowrap py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                                Name
                            </th>
                            <th scope="col"
                                class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">
                                Email
                            </th>
                            <th scope="col"
                                class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">
                                Phone
                            </th>
                            <th scope="col"
                                class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">
                                Completed Courses
                            </th>
                            <th scope="col"
                                class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">
                                Role
                            </th>
                            <th scope="col" class="relative whitespace-nowrap py-3.5 pl-3 pr-4 sm:pr-0">
                                <span class="sr-only">View</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                        @foreach($users as $user)
                            <livewire:central.employee.index-item :user="$user" :key="$user->id"/>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{ $users->links() }}
    </div>
</div>
