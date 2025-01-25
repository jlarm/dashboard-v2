<div>
    <x-slot name="header">
        <x-slot name="pageTitle">Courses</x-slot>
    </x-slot>
    <div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2 md:gap-4">
        @foreach($courses as $course)
            <livewire:tenant.course.index-item :course="$course" />
        @endforeach
        </div>
    </div>
</div>
