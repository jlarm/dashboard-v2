@php
    /** @var \App\Domain\Tenant\Course\Queries\GetUserCourseList $listCourses */
    $listCourses = app(\App\Domain\Tenant\Course\Queries\GetUserCourseList::class);
    $courses = $listCourses->handle(auth()->user())->map(fn ($item) => $item->toArray());
@endphp

<div class="p-5 bg-white border border-gray-200 shadow-sm rounded-xl">
    @if($courses->isEmpty())
        <p class="text-sm text-gray-500">No courses are assigned to you yet.</p>
    @else
        <div class="grid grid-cols-2 gap-2 md:grid-cols-3 md:gap-4 lg:grid-cols-4">
            @foreach($courses as $course)
                @php
                    $isClickable = $course['has_questions'] && ! $course['is_locked'];
                    $badgeClass = match (true) {
                        $course['is_locked'] => 'bg-gray-100 text-gray-600',
                        $course['status'] === 'passed' => 'bg-emerald-100 text-emerald-800',
                        $course['status'] === 'failed', $course['status'] === 'expired' => 'bg-red-100 text-red-800',
                        default => 'bg-gray-100 text-gray-700',
                    };
                @endphp
                <div @class([
                    'relative flex flex-col rounded-xl border p-4',
                    'cursor-not-allowed border-gray-200 bg-gray-50 opacity-50' => $course['is_locked'],
                    'border-gray-200 bg-white hover:border-gray-400' => ! $course['is_locked'],
                ])>
                    <h4 class="mb-2.5 font-medium text-sm text-gray-800">
                        {{ \Illuminate\Support\Str::limit($course['name'], 30) }}
                    </h4>
                    <div class="flex justify-between items-center gap-x-2">
                        <span class="text-xs text-gray-600">Grade:</span>
                        <span class="text-sm font-medium text-gray-800">
                            @if($course['status'] === 'passed' && $course['percentage'] !== null)
                                {{ $course['percentage'] }}%
                            @else
                                —
                            @endif
                        </span>
                    </div>
                    <div class="flex justify-between items-center gap-x-2 mt-1">
                        <span class="text-xs text-gray-600">Status:</span>
                        <span @class([
                            'inline-flex items-center gap-x-1.5 py-0.5 px-1.5 rounded-md text-xs font-medium',
                            $badgeClass,
                        ])>{{ $course['status_label'] }}</span>
                    </div>
                    @if($isClickable)
                        <a href="{{ route('dealer.courses.show', $course['slug']) }}" class="absolute inset-0 z-10" aria-label="Open {{ $course['name'] }}"></a>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>
