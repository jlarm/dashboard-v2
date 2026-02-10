<div>
    <x-slot name="header">
        <x-slot name="pageTitle">Courses</x-slot>
    </x-slot>
    <div class="space-y-4">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2 md:gap-4">
            @forelse($courses as $course)
                <livewire:dealer.course.index-item
                    :course="$course"
                    :module1="$module1"
                    :module2="$module2"
                    :module3="$module3"
                    :key="$course->id"/>
            @empty
                <p>No Courses Available</p>
            @endforelse
        </div>
    </div>
    <script>
        const div = document.getElementsByClassName('pointer-events-none');
        for (let i = 0; i < div.length; i++) {
            div[i].classList.add('opacity-25');
        }
    </script>
</div>
