<div>
    <span class="font-semibold text-2xl text-arm-blue-700">{{ Auth::user()->store->name ?? tenant('name')  }}</span>
    <span class="font-semibold text-2xl text-arm-blue-400 ml-1">{{ Auth::user()->department->name ?? '' }}</span>
</div>
