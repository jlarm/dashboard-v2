@if($course->results->first())
    {{ $course->results->first()->created_at->format('F d, Y') ?? __('-') }}
@else
    {{ __('Never') }}
@endif
