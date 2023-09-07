<div class="border rounded-md px-5 py-3 m-5 shadow">
    <div class="flex justify-between items-center">
        <div>
            SOC Monitoring
            @if($active != null)
                <span class="block text-sm text-gray-400">Active: {{ $active[0]->format('m/d/Y') }}</span>
            @else
                <span class="block text-sm text-gray-400">Call for more information</span>
            @endif
        </div>
        <span class="relative flex h-3 w-3">
            @if($active != null)
                <span
                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
              </span>
        @endif
    </div>
</div>
