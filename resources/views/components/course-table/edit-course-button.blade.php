@can('create-dealerships')
    @if(!$course->results->first())
        <span
            onclick="Livewire.emit('modal.open', 'dealer.employee.edit-course-taken', @js(['course' => $course->id, 'user' => $user->id]))"
            class="text-arm-blue-600 hover:text-arm-blue-900 hover:cursor-pointer">
            Edit
        </span>
    @endif
@endcan
