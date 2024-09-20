<div class="bg-gray-100 p-5 mt-5 rounded-md">
    <div class="w-full border-b mb-5">
        <p class="w-full text-xl">Add additional courses:</p>
    </div>
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
            <label for="{{ $course->id }}" class="text-gray-700">{{ Str::limit($course->name, 90) }}</label>
        </div>
    </div>
@endforeach
</div>
