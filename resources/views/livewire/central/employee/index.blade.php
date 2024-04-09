<div class="bg-white rounded-md p-6">
    <div>
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-xl font-bold leading-none tracking-tight text-neutral-900">Employees</h1>
            </div>
            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                <div class="flex justify-end">
                    <x-primary-link-button href="{{ route('employees.invite') }}">Add Employee</x-primary-link-button>
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
                    <x-table>
                        <x-slot name="head">
                            <x-table.heading>Name</x-table.heading>
                            <x-table.heading>Email</x-table.heading>
                            <x-table.heading>Phone</x-table.heading>
                            <x-table.heading>Completed Courses</x-table.heading>
                            <x-table.heading>Role</x-table.heading>
                            <x-table.heading></x-table.heading>
                        </x-slot>
                        <x-slot name="body">
                            @foreach($users as $user)
                                <livewire:central.employee.index-item :user="$user" :key="$user->id"/>
                            @endforeach
                        </x-slot>
                    </x-table>
                </div>
            </div>
        </div>
        {{ $users->links() }}
    </div>
</div>
