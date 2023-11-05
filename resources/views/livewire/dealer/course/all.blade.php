<div>
    <div class="space-y-4">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3 px-3 sm:px-0">
            @forelse($courses as $course)
                <div
                    class="relative flex items-center space-x-3 rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm focus-within:ring-2 focus-within:ring-arm-blue-500 focus-within:ring-offset-2 hover:border-gray-400">
                    <div class="min-w-0 flex-1">
                        <a
                            href="{{ route('dealer.courses.show', $course) }}"
                            class="focus:outline-none">
                            <span class="absolute inset-0" aria-hidden="true"></span>
                            <p
                                class="text-sm font-medium text-gray-900"
                            >
                                {{ Str::limit($course->name, 30) }}
                            </p>
                            <div class="w-full flex justify-between">
                                <p class="truncate text-sm text-gray-500">
                                    @if(is_null($course->results->first()))
                                        {{ __('Not taken yet') }}
                                    @else
                                        @if($course->results->first()->passed === 1)
                                            <span class="text-green-500">
                                        {{ __('Passed On')}}: {{ Carbon\Carbon::parse($course->results->first()->created_at)->format('F d, Y') }}
                                    </span>
                                        @else
                                            <span class="text-red-800">
                                        {{ __('Last Attempt') }}: {{ Carbon\Carbon::parse($course->results->first()->created_at)->format('F d, Y') }}
                                    </span>
                                        @endif
                                    @endif
                                </p>
                                @if($course->results->first() && $course->results->first()->passed === 1)
                                    <span
                                        class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">
                                    {{ $course->results->first()->percentage }}%
                                </span>
                                @elseif($course->results->first() && $course->results->first()->passed === 0)
                                    <span
                                        class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800">
                                    {{ $course->results->first()->percentage }}%
                                </span>
                                @else
                                    {{ __('') }}
                                @endif
                            </div>
                        </a>
                    </div>
                </div>

            @empty
                <p>No Courses Available</p>
            @endforelse
        </div>
    </div>
</div>
