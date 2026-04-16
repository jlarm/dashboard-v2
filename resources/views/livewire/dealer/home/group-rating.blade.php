<div wire:init="loadRatings">
    @php($showGroupExecutiveSummary = auth()->user()?->hasAnyRole(['super-admin', 'Owner', 'GM', 'CFO', 'GSM', 'Qualified Individual']))
    @php($gridClass = $showGroupExecutiveSummary ? 'md:grid-cols-7' : 'md:grid-cols-5')

    @if($isLoading)
    <!-- Skeleton Loading State -->
    <div class="grid grid-cols-1 {{ $gridClass }} gap-6">
        @for ($i = 0; $i < 5; $i++)
            <div wire:key="rating-skeleton-{{ $i }}" class="p-4 flex flex-col bg-white border border-gray-200 rounded-xl">
                <div class="animate-pulse">
                    <div class="flex justify-between items-center mb-1">
                        <div class="h-10 bg-gray-200 rounded w-12"></div>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="h-4 bg-gray-200 rounded w-20"></div>
                        <div class="size-4 bg-gray-200 rounded"></div>
                    </div>
                </div>
            </div>
        @endfor
        @if($showGroupExecutiveSummary)
            <div wire:key="rating-skeleton-summary" class="md:col-span-2 p-4 flex flex-col bg-white border border-gray-200 rounded-xl">
                <div class="animate-pulse">
                    <div class="flex justify-between items-center mb-1">
                        <div class="h-10 bg-gray-200 rounded w-12"></div>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="h-4 bg-gray-200 rounded w-20"></div>
                        <div class="size-4 bg-gray-200 rounded"></div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    @else
    <!-- Actual Content -->
    <div class="grid grid-cols-1 {{ $gridClass }} gap-6">
        <div class="p-4 flex flex-col bg-white border border-gray-200 rounded-xl">
            <div class="flex justify-between items-center mb-1">
                <h2 class="text-2xl font-semibold text-gray-800">
                    {{ $rating ?? '-' }}
                </h2>
                <div class="flex items-center -space-x-2">
                </div>
            </div>
            <div class="flex justify-between items-center">
                <h3 class="text-gray-500 text-sm">
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
        <div class="p-4 flex flex-col bg-white border border-gray-200 rounded-xl">
            <div class="flex justify-between items-center mb-1">
                <h2 class="text-2xl font-semibold text-gray-800">
                    {{ $this->oshaRating ?? '-' }}
                </h2>
                <div class="flex items-center -space-x-2">
                </div>
            </div>
            <div class="flex justify-between items-center">
                <h3 class="text-gray-500 text-sm">
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
        <div class="p-4 flex flex-col bg-white border border-gray-200 rounded-xl">
            <div class="flex justify-between items-center mb-1">
                <h2 class="text-2xl font-semibold text-gray-800">
                    {{ $this->dealJacketRating ?? '-' }}
                </h2>
                <div class="flex items-center -space-x-2">
                </div>
            </div>
            <div class="flex justify-between items-center">
                <h3 class="text-gray-500 text-sm">
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
        <div class="p-4 flex flex-col bg-white border border-gray-200 rounded-xl">
            <div class="flex justify-between items-center mb-1">
                <h2 class="text-2xl font-semibold text-gray-800">
                    {{ $this->glbaRating ?? '-' }}
                </h2>
                <div class="flex items-center -space-x-2">
                </div>
            </div>
            <div class="flex justify-between items-center">
                <h3 class="text-gray-500 text-sm">
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
        <div class="p-4 flex flex-col bg-white border border-gray-200 rounded-xl">
            <div class="flex justify-between items-center mb-1">
                <h2 class="text-2xl font-semibold text-gray-800">
                    {{ $this->bodyShopRating ?? '-' }}
                </h2>
                <div class="flex items-center -space-x-2">
                </div>
            </div>
            <div class="flex justify-between items-center">
                <h3 class="text-gray-500 text-sm">
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
        @if($showGroupExecutiveSummary)
            <livewire:dealer.home.group-executive-summary/>
        @endif
    </div>
    @endif
</div>
