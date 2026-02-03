<div wire:init="loadStats">
    <ul class="space-y-4">
        @if($readyToLoad && count($stats) > 0)
            @foreach($departments as $key => $department)
                @php
                    $stat = $stats[$key] ?? null;
                    $formattedName = str_replace(' ', '', $stat['name'] ?? '');
                    $formattedName = str_replace('/', '', $formattedName);
                    $percentage = $stat['percentage'] ?? 0;
                @endphp

                @if($stat)
                    <li wire:key="dept-{{ $key }}" class="flex justify-between items-center gap-x-2">
                        <div class="w-full grid grid-cols-2 items-center gap-x-2">
                            <span class="text-sm text-gray-800">
                                {{ $formattedName }}
                            </span>
                            <div class="flex justify-end" role="progressbar" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100">
                                <div class="h-1.5 flex flex-col justify-center overflow-hidden bg-arm-green-500 rounded-full text-xs text-white text-center whitespace-nowrap" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                        <div class="min-w-[60px] text-end">
                            <span class="text-sm text-gray-500">
                                {{ $percentage }}%
                            </span>
                        </div>
                    </li>
                @endif
            @endforeach
        @else
            @foreach(range(1, 8) as $i)
                <li wire:key="skeleton-{{ $i }}" class="flex justify-between items-center gap-x-2">
                    <div class="w-full grid grid-cols-2 items-center gap-x-2">
                        <div class="h-4 bg-gray-200 rounded animate-pulse"></div>
                        <div class="h-1.5 bg-gray-200 rounded animate-pulse"></div>
                    </div>
                    <div class="min-w-[60px]">
                        <div class="h-4 bg-gray-200 rounded animate-pulse"></div>
                    </div>
                </li>
            @endforeach
        @endif
    </ul>
</div>
