<div>
    <div class="space-y-4">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3 px-3 sm:px-0">
            @forelse($courses as $course)
                <livewire:dealer.course.index-item :course="$course" :key="$course->id"/>
            @empty
                <p>No Courses Available</p>
            @endforelse
        </div>
    </div>
    <script>
        const div = document.getElementsByClassName('pointer-events-none');
        for (let i = 0; i < div.length; i++) {
            div[i].parentElement.classList.add('opacity-25');
        }
    </script>
</div>
