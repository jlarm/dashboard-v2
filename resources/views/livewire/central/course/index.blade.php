<div class="space-y-5">
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-xl font-bold leading-none tracking-tight text-neutral-900">Courses</h1>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
            <div class="flex justify-end">

            </div>
        </div>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2 md:gap-4">
        @foreach($courses as $course)
            <div class="relative p-4 flex flex-col bg-white hover:border-gray-400 border border-gray-200 rounded-xl">
                <div class="space-y-1">
                    <h4 class="mb-2.5 font-medium text-sm text-gray-800">
                        {{ $course->name }}
                    </h4>

                    <!-- Item -->
                    <div class="flex justify-between items-center gap-x-2">
                        <span class="text-xs text-gray-600">
                          Grade:
                        </span>
                        <span class="text-sm font-medium text-gray-800">
                           @if($course->results->first() && Carbon\Carbon::parse($course->results->first()->created_at)->diffInDays() < 365)
                                    {{ $course->results->first()->percentage }}%
                            @else
                                {{ __('-') }}
                            @endif
                        </span>
                    </div>
                    <!-- End Item -->

                    <!-- Item -->
                    <div class="flex justify-between items-center gap-x-2">
                        <span class="text-xs text-gray-600">
                          Status:
                        </span>

                        @if($course->results->isEmpty())
                            <span class="inline-flex items-center gap-x-1.5 py-0.5 px-1.5 rounded-md text-xs font-medium bg-gray-100 text-gray-800">
                                {{ __('Not taken yet') }}
                            </span>
                        @else
                            @if(Carbon\Carbon::parse($course->results->first()->created_at)->diffInDays() > 365)
                                <span class="inline-flex items-center gap-x-1.5 py-0.5 px-1.5 rounded-md text-xs font-medium bg-red-100 text-red-800">
                                    {{ __('Expired: Need To Retake') }}
                                </span>
                            @else
                                @if($course->results->first()->passed === 1)
                                    <span class="inline-flex items-center gap-x-1.5 py-0.5 px-1.5 rounded-md text-xs font-medium bg-teal-100 text-teal-800">
                                        Passed On: {{ Carbon\Carbon::parse($course->results->first()->created_at)->format('F d, Y') }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-x-1.5 py-0.5 px-1.5 rounded-md text-xs font-medium bg-red-100 text-red-800">
                                        Last Attempt: {{ Carbon\Carbon::parse($course->results->first()->created_at)->format('F d, Y') }}
                                    </span>
                                @endif
                            @endif
                        @endif
                    </div>
                    <!-- End Item -->
                </div>
                @if(count($course->questions))
                <a class="after:absolute after:inset-0 after:z-10" href="{{ route('courses.show', $course) }}"></a>
                @endif
            </div>
        @endforeach
    </div>
    <div class="mt-5">
        {{ $courses->links() }}
    </div>
</div>
