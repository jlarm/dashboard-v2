<div>
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
        @forelse($courses as $course)
            <div class="relative flex items-center space-x-3 rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm focus-within:ring-2 focus-within:ring-arm-blue-500 focus-within:ring-offset-2 hover:border-gray-400">
                <div class="min-w-0 flex-1">
                    <a href="{{ route('dealer.courses.show', $course) }}" class="focus:outline-none">
                        <span class="absolute inset-0" aria-hidden="true"></span>
                        <p class="text-sm font-medium text-gray-900">{{ $course->name }}</p>
                        <p class="truncate text-sm text-gray-500">
                            @if(is_null($course->results->first()))
                                {{ __('Not taken yet') }}
                            @else
                                @if($courses->first()->results->first()->passed === 1)
                                    <span class="text-green-500">
                                    Passed On: {{ Carbon\Carbon::parse($course->results->first()->created_at)->format('F d, Y') }}
                                </span>
                                @else
                                    <span class="text-orange-500">
                                    Last Attempt: {{ Carbon\Carbon::parse($course->results->first()->created_at)->format('F d, Y') }}
                                </span>
                                @endif
                            @endif
                        </p>
                    </a>
                </div>
            </div>
        @empty
            <p>No Courses Available</p>
        @endforelse
    </div>
    {{ $courses->links() }}
</div>
