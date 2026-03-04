@php
    $latestResult = $course->results->first();
@endphp

@if($latestResult)
    @php
        $yearsExpires = $course->years_expires ?? 1;
        $expirationDate = $latestResult->created_at->copy()->addYears($yearsExpires);
        $isExpired = $expirationDate->isPast();
    @endphp

    @if($latestResult->passed === 1)
        @if($isExpired)
            @include('components.course-table.status-badge', ['type' => 'expired', 'text' => 'Retake Required (' . $expirationDate->format('F d, Y') . ')'])
        @else
            @include('components.course-table.status-badge', ['type' => 'passed', 'text' => "Passed: {$latestResult->percentage}%"])
        @endif
    @else
        @include('components.course-table.status-badge', ['type' => 'failed', 'text' => "Failed: {$latestResult->percentage}%"])
    @endif
@else
    {{ __('-') }}
@endif
