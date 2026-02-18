<x-dealer-app>
    <x-slot:header>
        <x-slot:pageTitle>Deal Jacket Audit for {{ $dealJacket->customer_name }}</x-slot:pageTitle>
    </x-slot:header>
    <x-slot:actions>
        <x-button :href="tenant('locations') ? route('dealer.stores.audits.deal-jackets.show', [$store, $dealJacketGroup]) : route('dealer.audit.deal-jackets.show', $dealJacketGroup)">Back</x-button>
    </x-slot:actions>
    <div class="grid grid-cols-3 gap-5">
        <div class="col-span-2 border shadow-sm p-6 rounded-lg space-y-3">
            <h2 class="font-semibold text-gray-800">Violations</h2>
            <div class="flex flex-col">
                @foreach($dealJacket->responses as $index => $response)
                    @if($response['answer'] === 'no')
                        <div class="flex justify-between gap-5 py-2.5 first:pt-0 last:pb-0 first:border-t-0 border-t border-dashed border-gray-200">
                            <div class="grow">
                                <span class="block text-sm text-gray-800">{{ $response['statement'] }}</span>
                                <small class="block text-xs text-gray-500 dark:text-neutral-400">
                                    {{ $response['comment'] }}
                                </small>
                            </div>
                            <div class="w-28 flex justify-end items-center gap-x-1 whitespace-nowrap">
                                @if($response['high_risk'])
                                    <div class="inline-flex items-center gap-x-1.5 px-3 py-1.5 rounded-lg text-xs font-medium bg-red-100 text-red-800">
                                        <svg class="shrink-0 size-3.5 " xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                                        <small>
                                            High Risk
                                        </small>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        <div class="border shadow-sm rounded-lg p-6 space-y-3">
            <div>
                <h2 class="font-semibold text-gray-800">Pass Rate</h2>
                <h4 class="text-5xl md:text-6xl font-black text-arm-blue-500">
                <span class="">
                 {{ $dealJacket->percentage }}%
                </span>
                </h4>
            </div>
            <div class="divide-y divide-dashed divide-gray-200">
                <div class="py-3 grid grid-cols-2 gap-x-3">
                    <span class="block text-sm text-gray-500">
                      Customer name:
                    </span>

                    <div class="flex justify-end gap-2">
                        <span class="text-sm text-gray-800">{{ $dealJacket->customer_name }}</span>
                    </div>
                </div>
                <div class="py-3 grid grid-cols-2 gap-x-3">
                    <span class="block text-sm text-gray-500">
                      Customer number:
                    </span>

                    <div class="flex justify-end gap-2">
                        <span class="text-sm text-gray-800">{{ $dealJacket->customer_deal_number }}</span>
                    </div>
                </div>
                <div class="py-3 grid grid-cols-2 gap-x-3">
                    <span class="block text-sm text-gray-500">
                      Customer number:
                    </span>

                    <div class="flex justify-end gap-2">
                        <span class="text-sm text-gray-800">{{ $dealJacket->date_of_deal_jacket->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>

            <div class="divide-y divide-dashed divide-gray-200">
                <div class="py-3 grid grid-cols-2 gap-x-3">
                    <span class="block text-sm text-gray-500">
                      Purchase type:
                    </span>

                    <div class="flex justify-end gap-2">
                        <span class="text-sm text-gray-800">{{ Str::title($dealJacket->purchase_type) }}</span>
                    </div>
                </div>
                <div class="py-3 grid grid-cols-2 gap-x-3">
                    <span class="block text-sm text-gray-500">
                      Vehicle type:
                    </span>

                    <div class="flex justify-end gap-2">
                        <span class="text-sm text-gray-800">{{ Str::title($dealJacket->vehicle_type) }}</span>
                    </div>
                </div>
                <div class="py-3 grid grid-cols-2 gap-x-3">
                    <span class="block text-sm text-gray-500">
                      Mileage:
                    </span>

                    <div class="flex justify-end gap-2">
                        <span class="text-sm text-gray-800">{{ $dealJacket->mileage }}</span>
                    </div>
                </div>
            </div>

            <div class="divide-y divide-dashed divide-gray-200">
                <div class="py-3 grid grid-cols-2 gap-x-3">
                    <span class="block text-sm text-gray-500">
                      Finance manager:
                    </span>

                    <div class="flex justify-end gap-2">
                        <span class="text-sm text-gray-800">{{ Str::title($dealJacket->user?->name ?? 'House') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dealer-app>
