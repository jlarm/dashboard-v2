<div
    class="relative p-4 flex flex-col bg-white hover:border-gray-400 border border-gray-200 rounded-xl">
    <div class="min-w-0 flex-1
        @if(
            $course->slug === 'dot-hazardous-materials-transportation-identifying-hazardous-materials' ||
            $course->slug === 'dot-hazardous-materials-transportation-preparing-hazardous-materials-for-shipment' ||
            $course->slug === 'dot-hazardous-materials-transportation-shipping-papers-emergency-response-and-placarding'
            )
            @if($module1 != 1)
                pointer-events-none
            @endif
        @endif
        @if(
            $course->slug === 'dot-hazardous-materials-transportation-preparing-hazardous-materials-for-shipment' ||
            $course->slug === 'dot-hazardous-materials-transportation-shipping-papers-emergency-response-and-placarding'
            )
            @if($module2 != 1)
                pointer-events-none
            @endif
        @endif
        @if($course->slug === 'dot-hazardous-materials-transportation-shipping-papers-emergency-response-and-placarding')
            @if($module3 != 1)
                pointer-events-none
            @endif
        @endif
        ">
        <div class="space-y-1">
            <h4 class="mb-2.5 font-medium text-sm text-gray-800">
                {{ Str::limit(__($course->name), 30) }}
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

                @if($course->slug === 'dot-hazardous-materials-transportation' || $course->slug === 'dot-hazardous-materials-transportation-identifying-hazardous-materials' || $course->slug === 'dot-hazardous-materials-transportation-preparing-hazardous-materials-for-shipment' || $course->slug === 'dot-hazardous-materials-transportation-shipping-papers-emergency-response-and-placarding')
                    @if($course->results->isEmpty())
                        <span class="inline-flex items-center gap-x-1.5 py-0.5 px-1.5 rounded-md text-xs font-medium bg-gray-100 text-gray-800">
                        {{ __('Not taken yet') }}
                    </span>
                    @else
                        @if(Carbon\Carbon::parse($course->results->first()->created_at)->diffInDays() > 1095)
                            <span class="inline-flex items-center gap-x-1.5 py-0.5 px-1.5 rounded-md text-xs font-medium bg-red-100 text-red-800">
                            {{ __('Retake Required') }}
                        </span>
                        @else
                            @if($course->results->first()->passed === 1)
                                <span class="inline-flex items-center gap-x-1.5 py-0.5 px-1.5 rounded-md text-xs font-medium bg-teal-100 text-teal-800">
                                Passed On: {{ Carbon\Carbon::parse($course->results->first()->created_at)->format('M d, Y') }}
                            </span>
                            @else
                                <span class="inline-flex items-center gap-x-1.5 py-0.5 px-1.5 rounded-md text-xs font-medium bg-red-100 text-red-800">
                                Last Attempt: {{ Carbon\Carbon::parse($course->results->first()->created_at)->format('M d, Y') }}
                            </span>
                            @endif
                        @endif
                    @endif
                @else
                    @if($course->results->isEmpty())
                        <span class="inline-flex items-center gap-x-1.5 py-0.5 px-1.5 rounded-md text-xs font-medium bg-gray-100 text-gray-800">
                        {{ __('Not taken yet') }}
                    </span>
                    @else
                        @if(Carbon\Carbon::parse($course->results->first()->created_at)->diffInDays() > 365)
                            <span class="inline-flex items-center gap-x-1.5 py-0.5 px-1.5 rounded-md text-xs font-medium bg-red-100 text-red-800">
                            {{ __('Retake Required') }}
                        </span>
                        @else
                            @if($course->results->first()->passed === 1)
                                <span class="inline-flex items-center gap-x-1.5 py-0.5 px-1.5 rounded-md text-xs font-medium bg-teal-100 text-teal-800">
                                Passed On: {{ Carbon\Carbon::parse($course->results->first()->created_at)->format('M d, Y') }}
                            </span>
                            @else
                                <span class="inline-flex items-center gap-x-1.5 py-0.5 px-1.5 rounded-md text-xs font-medium bg-red-100 text-red-800">
                                Last Attempt: {{ Carbon\Carbon::parse($course->results->first()->created_at)->format('M d, Y') }}
                            </span>
                            @endif
                        @endif
                    @endif
                @endif

            </div>
            <!-- End Item -->

            @if(count($course->questions))
                <a class="after:absolute after:inset-0 after:z-10" href="{{ route('courses.show', $course) }}"></a>
            @endif
        </div>
    </div>
</div>
