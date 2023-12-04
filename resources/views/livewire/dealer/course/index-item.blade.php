<div
    class="relative flex items-center space-x-3 rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm focus-within:ring-2 focus-within:ring-arm-blue-500 focus-within:ring-offset-2 hover:border-gray-400">
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
                    @elseif($course->results->first()->passed === 1 && $course->results->first()->created_at->diffInDays() > 365)
                        <span class="text-orange-500">
                            {{ __('Expired On: ') }} {{ $course->results->first()->created_at->format('F d, Y') }}
                        </span>
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
                @if($course->results->first() && $course->results->first()->passed === 1 && $course->results->first()->created_at->diffInDays() < 365)
                    <span
                        class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">
                                    {{ $course->results->first()->percentage }}%
                                </span>
                @elseif($course->results->first() && $course->results->first()->passed === 0 && $course->results->first()->created_at->diffInDays() < 365)
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
