<div wire:init="loadRatings">
{{--    <p class="font-bold text-2xl">Overall Audit Ratings</p>--}}
{{--    <p class="text-sm text-gray-500 mb-5">Based on all stores in your group</p>--}}

    <!-- Skeleton Loading State -->
    <div x-show="$wire.isLoading" class="grid grid-cols-1 md:grid-cols-5 gap-6">
        @for ($i = 0; $i < 5; $i++)
            <div wire:key="rating-skeleton-{{ $i }}" class="p-4 flex flex-col bg-white border border-gray-200 rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
                <div class="animate-pulse">
                    <div class="flex justify-between items-center mb-1">
                        <div class="h-10 bg-gray-200 rounded w-12 dark:bg-neutral-700"></div>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="h-4 bg-gray-200 rounded w-20 dark:bg-neutral-700"></div>
                        <div class="size-4 bg-gray-200 rounded dark:bg-neutral-700"></div>
                    </div>
                </div>
            </div>
        @endfor
    </div>

    <!-- Actual Content -->
    <div x-show="!$wire.isLoading" class="grid grid-cols-1 md:grid-cols-5 gap-6">
        <div class="p-4 flex flex-col bg-white border border-gray-200 rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
            <div class="flex justify-between items-center mb-1">
                <h2 class="text-4xl font-semibold text-gray-800 dark:text-neutral-200">
                    {{ $rating ?? '-' }}
                </h2>
                <div class="flex items-center -space-x-2">
                </div>
            </div>
            <div class="flex justify-between items-center">
                <h3 class="text-gray-500 dark:text-neutral-500">
                    Overall
                </h3>
                <x-tooltip
                    placement="top"
                    trigger="hover"
                    content="Based on your assigned stores"
                    :delay="100"
                >
                    <svg class="size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" color="#000000" fill="none">
                        <path d="M2.5 12C2.5 7.52166 2.5 5.28249 3.89124 3.89124C5.28249 2.5 7.52166 2.5 12 2.5C16.4783 2.5 18.7175 2.5 20.1088 3.89124C21.5 5.28249 21.5 7.52166 21.5 12C21.5 16.4783 21.5 18.7175 20.1088 20.1088C18.7175 21.5 16.4783 21.5 12 21.5C7.52166 21.5 5.28249 21.5 3.89124 20.1088C2.5 18.7175 2.5 16.4783 2.5 12Z" stroke="#141B34" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M12 8V12.5" stroke="#141B34" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M12 15.9883V15.9983" stroke="#141B34" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </x-tooltip>
            </div>
        </div>
        <div class="p-4 flex flex-col bg-white border border-gray-200 rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
            <div class="flex justify-between items-center mb-1">
                <h2 class="text-4xl font-semibold text-gray-800 dark:text-neutral-200">
                    {{ $this->oshaRating ?? '-' }}
                </h2>
                <div class="flex items-center -space-x-2">
                </div>
            </div>
            <div class="flex justify-between items-center">
                <h3 class="text-gray-500 dark:text-neutral-500">
                    OSHA
                </h3>
                <x-tooltip
                    placement="top"
                    trigger="hover"
                    content="Based on your assigned stores"
                    :delay="100"
                >
                    <svg class="size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" color="#000000" fill="none">
                        <path d="M2.5 12C2.5 7.52166 2.5 5.28249 3.89124 3.89124C5.28249 2.5 7.52166 2.5 12 2.5C16.4783 2.5 18.7175 2.5 20.1088 3.89124C21.5 5.28249 21.5 7.52166 21.5 12C21.5 16.4783 21.5 18.7175 20.1088 20.1088C18.7175 21.5 16.4783 21.5 12 21.5C7.52166 21.5 5.28249 21.5 3.89124 20.1088C2.5 18.7175 2.5 16.4783 2.5 12Z" stroke="#141B34" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M12 8V12.5" stroke="#141B34" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M12 15.9883V15.9983" stroke="#141B34" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </x-tooltip>
            </div>
        </div>
        <div class="p-4 flex flex-col bg-white border border-gray-200 rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
            <div class="flex justify-between items-center mb-1">
                <h2 class="text-4xl font-semibold text-gray-800 dark:text-neutral-200">
                    {{ $this->dealJacketRating ?? '-' }}
                </h2>
                <div class="flex items-center -space-x-2">
                </div>
            </div>
            <div class="flex justify-between items-center">
                <h3 class="text-gray-500 dark:text-neutral-500">
                    Deal Jackets
                </h3>
                <x-tooltip
                    placement="top"
                    trigger="hover"
                    content="Based on your assigned stores"
                    :delay="100"
                >
                    <svg class="size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" color="#000000" fill="none">
                        <path d="M2.5 12C2.5 7.52166 2.5 5.28249 3.89124 3.89124C5.28249 2.5 7.52166 2.5 12 2.5C16.4783 2.5 18.7175 2.5 20.1088 3.89124C21.5 5.28249 21.5 7.52166 21.5 12C21.5 16.4783 21.5 18.7175 20.1088 20.1088C18.7175 21.5 16.4783 21.5 12 21.5C7.52166 21.5 5.28249 21.5 3.89124 20.1088C2.5 18.7175 2.5 16.4783 2.5 12Z" stroke="#141B34" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M12 8V12.5" stroke="#141B34" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M12 15.9883V15.9983" stroke="#141B34" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </x-tooltip>
            </div>
        </div>
        <div class="p-4 flex flex-col bg-white border border-gray-200 rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
            <div class="flex justify-between items-center mb-1">
                <h2 class="text-4xl font-semibold text-gray-800 dark:text-neutral-200">
                    {{ $this->glbaRating ?? '-' }}
                </h2>
                <div class="flex items-center -space-x-2">
                </div>
            </div>
            <div class="flex justify-between items-center">
                <h3 class="text-gray-500 dark:text-neutral-500">
                    GLBA
                </h3>
                <x-tooltip
                    placement="top"
                    trigger="hover"
                    content="Based on your assigned stores"
                    :delay="100"
                >
                    <svg class="size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" color="#000000" fill="none">
                        <path d="M2.5 12C2.5 7.52166 2.5 5.28249 3.89124 3.89124C5.28249 2.5 7.52166 2.5 12 2.5C16.4783 2.5 18.7175 2.5 20.1088 3.89124C21.5 5.28249 21.5 7.52166 21.5 12C21.5 16.4783 21.5 18.7175 20.1088 20.1088C18.7175 21.5 16.4783 21.5 12 21.5C7.52166 21.5 5.28249 21.5 3.89124 20.1088C2.5 18.7175 2.5 16.4783 2.5 12Z" stroke="#141B34" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M12 8V12.5" stroke="#141B34" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M12 15.9883V15.9983" stroke="#141B34" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </x-tooltip>
            </div>
        </div>
        <div class="p-4 flex flex-col bg-white border border-gray-200 rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
            <div class="flex justify-between items-center mb-1">
                <h2 class="text-4xl font-semibold text-gray-800 dark:text-neutral-200">
                    {{ $this->bodyShopRating ?? '-' }}
                </h2>
                <div class="flex items-center -space-x-2">
                </div>
            </div>
            <div class="flex justify-between items-center">
                <h3 class="text-gray-500 dark:text-neutral-500">
                    Body Shop
                </h3>
                <x-tooltip
                    placement="left"
                    trigger="hover"
                    content="Based on your assigned stores"
                    :delay="100"
                    >
                    <svg class="size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" color="#000000" fill="none">
                        <path d="M2.5 12C2.5 7.52166 2.5 5.28249 3.89124 3.89124C5.28249 2.5 7.52166 2.5 12 2.5C16.4783 2.5 18.7175 2.5 20.1088 3.89124C21.5 5.28249 21.5 7.52166 21.5 12C21.5 16.4783 21.5 18.7175 20.1088 20.1088C18.7175 21.5 16.4783 21.5 12 21.5C7.52166 21.5 5.28249 21.5 3.89124 20.1088C2.5 18.7175 2.5 16.4783 2.5 12Z" stroke="#141B34" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M12 8V12.5" stroke="#141B34" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M12 15.9883V15.9983" stroke="#141B34" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </x-tooltip>
            </div>
        </div>
    </div>
</div>
