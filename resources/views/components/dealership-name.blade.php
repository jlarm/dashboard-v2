@props(['title'])
<div>
{{--    @if(Auth::user()->stores->count() > 0)--}}
{{--        <span class="font-semibold text-2xl text-arm-blue-700">{{ Auth::user()->stores->first()->name }}</span>--}}
{{--    @else--}}
{{--        <span class="font-semibold text-2xl text-arm-blue-700">{{ $title ?? tenant('name') }}</span>--}}
{{--    @endif--}}
{{--    <span--}}
{{--        class="font-semibold text-2xl text-arm-orange-500 ml-1">{{ Auth::user()->department->name ?? '' }}</span>--}}
    {{ $current_store_name }}
</div>
