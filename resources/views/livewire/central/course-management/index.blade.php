<div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
    <div class="col-span-4 bg-white rounded-md p-6 flex flex-col space-y-5">
        <div class="flex flex-col gap-4 xl:flex-row xl:items-end xl:justify-between">
            <h1 class="text-xl font-bold leading-none tracking-tight text-neutral-900">Courses</h1>

            <x-primary-button onclick="Livewire.emit('modal.open', 'central.course-management.import')">
                Import Course
            </x-primary-button>
        </div>

        <table class="min-w-full divide-y divide-gray-300">
            <tbody class="divide-y divide-gray-200 bg-white">
            @forelse($courses as $course)
                <livewire:central.course-management.index-item :course="$course" :key="$course->id"/>
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
</div>
