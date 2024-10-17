<tr class="@if($store->state != 'California' && $course->slug === 'sexual-harassment-training-in-california') hidden @endif">
    <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm text-gray-500 sm:pl-0">
        {{ Str::limit($course->name, 40) }}
    </td>
    <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm text-gray-500 sm:pl-0">
        @include('components.course-table.last-taken-date', ['course' => $course])
    </td>
    <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm text-gray-500 sm:pl-0">
        @include('components.course-table.course-status', ['course' => $course])
    </td>
    <td class="relative whitespace-nowrap py-2 pl-4 pr-3 text-sm text-gray-500 sm:pl-0 text-right text-sm font-medium sm:pr-0">
        @include('components.course-table.edit-course-button', ['course' => $course, 'user' => $user])
    </td>
</tr>
