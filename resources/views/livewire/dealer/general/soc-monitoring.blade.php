<div class="relative w-full border border-transparent p-4 mt-auto {{ $monitoring->active_monitoring == 1 ? 'bg-green-50 text-green-600' : 'bg-blue-50 text-blue-500' }}">
    <h5 class="mb-1 font-medium leading-none tracking-tight">SOC Monitoring</h5>
    <div class="text-sm opacity-80">
        @if($monitoring->active_monitoring)
            Active: {{ $monitoring->monitoring_start_date?->format('m/d/Y') }}
        @else
            Call for more information
        @endif
    </div>
</div>

