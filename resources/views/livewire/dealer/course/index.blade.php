<div>
    <div class="space-y-4">
        {{--        <div class="md:w-1/3 px-3 sm:px-0">--}}
        {{--            <div>--}}
        {{--                <label for="search" class="sr-only">Search</label>--}}
        {{--                <input type="search" name="search" id="search"--}}
        {{--                       wire:model="search"--}}
        {{--                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"--}}
        {{--                       placeholder="Search Courses...">--}}
        {{--            </div>--}}
        {{--        </div>--}}
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3 px-3 sm:px-0">
            @forelse($courses as $course)
                <livewire:dealer.course.index-item :course="$course" :key="$course->id"/>
            @empty
                <p>No Courses Available</p>
            @endforelse
        </div>
        <div class="mt-10">
            {{--            {{ $courses->links() }}--}}
        </div>
    </div>
    <script>
        const div = document.getElementsByClassName('pointer-events-none');
        for (let i = 0; i < div.length; i++) {
            div[i].parentElement.classList.add('opacity-25');
        }
    </script>
</div>
