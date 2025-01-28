<div>
    <p class="my-5 text-sm font-bold">Check off any course you would like to make optional in the dealership. You can always assign a course to a specific employee.</p>
    <div class="spacey-y-2">
        @foreach($courses as $course)
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input
                        id="{{ $course->id }}"
                        wire:model="selectedCourses.{{ $course->id }}"
                        type="checkbox"
                        class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                    >
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="{{ $course->id }}" class="text-gray-700">{{ $course->name }} {{ $course->slug === 'sexual-harassment-e' ? '(Employees)' : '' }} {{ $course->slug === 'sexual-harassment-m' ? '(Managers)' : '' }}</label>
                </div>
            </div>
        @endforeach
    </div>
</div>
