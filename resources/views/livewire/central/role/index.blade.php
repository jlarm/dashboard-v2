<table class="min-w-full divide-y divide-gray-300">
    <thead class="bg-gray-50">
    <tr>
        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Name</th>
        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
            <span class="sr-only">Edit</span>
        </th>
    </tr>
    </thead>
    <tbody class="divide-y divide-gray-200 bg-white">
    @forelse($roles as $role)
        <livewire:central.role.index-item :role="$role" :key="$role->id"/>
    @empty
        <tr>
            <td class="py-4 pl-4 pr-3 text-center font-medium text-arm-blue-700 sm:pl-6" colspan="5">No Roles have
                been added.
            </td>
        </tr>
    @endforelse
    </tbody>
</table>
