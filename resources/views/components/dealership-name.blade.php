@props(['title'])
<div>
    <span class="font-semibold text-2xl text-arm-blue-700">{{ $title ?? tenant('name') }}</span>
    <span class="font-semibold text-2xl text-arm-orange-500 ml-1">{{ Auth::user()->department->name ?? '' }}</span>
</div>
