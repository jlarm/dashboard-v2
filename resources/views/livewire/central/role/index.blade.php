<div class="grid grid-cols-1 lg:grid-cols-6 gap-4">
    <div class="col-span-4 bg-white rounded-md p-6">
        <h1 class="text-xl font-bold leading-none tracking-tight text-neutral-900">Roles</h1>
        <table class="min-w-full divide-y divide-gray-300">
            <thead>
            <tr>
                <th scope="col"
                    class="whitespace-nowrap py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                    Name
                </th>
                <th scope="col"
                    class="whitespace-nowrap py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                    Permissions
                </th>
                <th scope="col" class="relative whitespace-nowrap py-3.5 pl-3 pr-4 sm:pr-0">
                    <span class="sr-only">Edit</span>
                </th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
            @forelse($roles as $role)
                <livewire:central.role.index-item :role="$role" :key="$role->id"/>
            @empty
                <tr>
                    <td class="py-4 pl-4 pr-3 text-center font-medium text-arm-blue-700 sm:pl-6" colspan="5">No Roles
                        have
                        been added.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="col-span-2 bg-white rounded-md p-6">
        <h1 class="text-xl font-bold leading-none tracking-tight text-neutral-900 mb-3.5">Create Role</h1>
        <livewire:central.role.create/>
    </div>
</div>
