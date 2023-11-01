<div class="grid grid-cols-1 lg:grid-cols-6 gap-4">
    <div class="col-span-4 bg-white rounded-md p-6">
        <h1 class="text-xl font-bold leading-none tracking-tight text-neutral-900">Departments</h1>
        <table class="min-w-full divide-y divide-gray-300 mt-3.5">
            <tbody class="divide-y divide-gray-200 bg-white">
            @forelse($departments as $department)
                <livewire:central.department.index-item :department="$department" :key="$department->id"/>
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
        <h1 class="text-xl font-bold leading-none tracking-tight text-neutral-900 mb-3.5">Create Department</h1>
        <livewire:central.department.create/>
    </div>
</div>
