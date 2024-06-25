<div class="p-4 flex flex-col bg-white border border-gray-200 rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
    <div class="space-y-1">
        <div class="flex justify-between items-center mb-2.5">
            <h4 class="font-medium text-sm text-gray-800 dark:text-neutral-300">
                {{ ucwords(strtolower(Str::limit($vendor->name, 20)))  }}
            </h4>
            <button onclick="Livewire.emit('slide-over.open', 'dealer.vendor.edit', @js(['vendor' => $vendor->id]))" type="button" class="size-[30px] inline-flex justify-center items-center rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 focus:outline-none focus:bg-gray-100 dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
                <svg class="flex-shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" color="#000000" fill="none">
                    <path d="M3 7.5V20.5H10M21 7.5V13" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                    <path d="M9.5 10.5H14.5" stroke="currentColor" stroke-width="1.5" />
                    <path d="M17 18H17.009" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M17 21.5C19.7614 21.5 22 18 22 18C22 18 19.7614 14.5 17 14.5C14.2386 14.5 12 18 12 18C12 18 14.2386 21.5 17 21.5Z" stroke="currentColor" stroke-width="1.5" />
                    <path d="M21.9 2.5H2.1C2.04477 2.5 2 2.54477 2 2.6V7.5H22V2.6C22 2.54477 21.9552 2.5 21.9 2.5Z" stroke="currentColor" stroke-width="1.5" />
                </svg>
            </button>
        </div>

        @if(tenant('locations'))
        <!-- Item -->
        <div class="flex justify-between items-center gap-x-2">
            <span class="text-xs text-gray-600 dark:text-neutral-400">
              Store:
            </span>

            <span class="text-xs text-gray-600 dark:text-neutral-400">
              {{ $vendor->store ? Str::limit($vendor->store->name, 20) : 'All Stores' }}
            </span>
        </div>
        <!-- End Item -->
        @endif

        <!-- Item -->
        <div class="flex justify-between items-center gap-x-2">
            <span class="text-xs text-gray-600 dark:text-neutral-400">
              Status:
            </span>

            @if($status !== '' && $status !== null || $vendor->signature)
            <span class="inline-flex items-center gap-x-1.5 py-0.5 px-1.5 rounded-md text-xs font-medium bg-teal-100 text-teal-800 dark:bg-teal-800/30 dark:text-teal-500">Current</span>
            @else
            <span class="inline-flex items-center gap-x-1.5 py-0.5 px-1.5 rounded-md text-xs font-medium bg-red-100 text-red-800 dark:bg-red-800/30 dark:text-red-500">Incomplete</span>
            @endif
        </div>
        <!-- End Item -->
    </div>
</div>
