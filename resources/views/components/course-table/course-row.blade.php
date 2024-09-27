<tr class="@if($store->state != 'California' && $course->slug === 'sexual-harassment-training-in-california') hidden @endif">
    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8">
        {{ Str::limit($course->name, 40) }}
    </td>
    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
        @include('components.course-table.last-taken-date', ['course' => $course])
    </td>
    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
        @include('components.course-table.course-status', ['course' => $course])
    </td>
    <td class="relative whitespace-nowrap py-2 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
        @include('components.course-table.edit-course-button', ['course' => $course, 'user' => $user])
    </td>
</tr>
