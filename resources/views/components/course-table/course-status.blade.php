@php
    $hazardousMaterialsSlugs = [
        'dot-hazardous-materials-transportation',
        'dot-hazardous-materials-transportation-identifying-hazardous-materials',
        'dot-hazardous-materials-transportation-preparing-hazardous-materials-for-shipment',
        'dot-hazardous-materials-transportation-shipping-papers-emergency-response-and-placarding'
    ];
    $courseSlug = trim($course->slug); // Ensure no leading/trailing whitespace
    $isHazardousMaterialsCourse = in_array($courseSlug, $hazardousMaterialsSlugs);
    $expirationMonths = $isHazardousMaterialsCourse ? 36 : 12;
    $latestResult = $course->results->first();
@endphp

@if($latestResult)
    @php
        $expirationDate = $latestResult->created_at->addMonths($expirationMonths);
        $isExpired = $expirationDate->isPast();
    @endphp

    @if($latestResult->passed === 1)
        @if($isExpired)
            @include('components.course-table.status-badge', ['type' => 'expired', 'text' => 'Expired ' . ($isHazardousMaterialsCourse ? '' : $latestResult->created_at->format('F d, Y'))])
        @else
            @include('components.course-table.status-badge', ['type' => 'passed', 'text' => "Passed: {$latestResult->percentage}%"])
        @endif
    @else
        @include('components.course-table.status-badge', ['type' => 'failed', 'text' => "Failed: {$latestResult->percentage}%"])
    @endif
@else
    {{ __('-') }}
@endif
