<div>
    @if($stats)
        <div class="border rounded-md p-5">
            <h1 class="font-bold text-xl">Grade</h1>
            <div class="text-center">
            <span class="inline-flex h-14 w-14 items-center justify-center rounded-full bg-gray-500 mx-auto">
              <span class="text-xl font-medium leading-none text-white">{{ $stats->grade ?? '-' }}</span>
            </span>
            </div>
        </div>
        <div class="border rounded-md p-5 mt-5">
            <h1 class="font-bold text-xl">Exploits</h1>
            <ul class="text-xs text-gray-500 divide-y divide-gray-100">
                <li class="flex justify-between gap-x-4 py-2">
                    <p class="text-red-600">High</p>
                    <p>{{ $stats->exploits_high ?? '-' }}</p>
                </li>
                <li class="flex justify-between gap-x-4 py-2">
                    <p class="text-yellow-600">Medium</p>
                    <p>{{ $stats->exploits_medium ?? '-' }}</p>
                </li>
                <li class="flex justify-between gap-x-4 py-2">
                    <p class="text-blue-600">Low</p>
                    <p>{{ $stats->exploits_low ?? '-' }}</p>
                </li>
            </ul>
        </div>
        <div class="border rounded-md p-5 mt-5">
            <h1 class="font-bold text-xl">CVEs</h1>
            <ul class="text-xs text-gray-500 divide-y divide-gray-100">
                <li class="flex justify-between gap-x-4 py-2">
                    <p class="text-red-600">High</p>
                    <p>{{ $stats->cves_high ?? '-' }}</p>
                </li>
                <li class="flex justify-between gap-x-4 py-2">
                    <p class="text-yellow-600">Medium</p>
                    <p>{{ $stats->cves_medium ?? '-' }}</p>
                </li>
                <li class="flex justify-between gap-x-4 py-2">
                    <p class="text-blue-600">Low</p>
                    <p>{{ $stats->cves_low ?? '-' }}</p>
                </li>
            </ul>
        </div>
        <livewire:dealer.scan.internal-scan-dates />
    @endif
</div>
