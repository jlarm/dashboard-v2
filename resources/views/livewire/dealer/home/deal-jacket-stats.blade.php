<div>
    <div class="relative overflow-hidden p-4 sm:p-5 bg-white border border-gray-200 rounded-xl shadow-sm before:absolute before:top-0 before:end-0 before:size-full before:bg-gradient-to-br before:from-green-100 before:via-transparent before:blur-xl">
        <a href="{{ !tenant('locations') ? route('dealer.audit.deal-jackets.index') : route('dealer.stores.audits.deal-jackets.index', $store) }}" class="relative z-0">
            <!-- Header -->
            <div class="flex justify-between gap-x-3">
                <!-- Icon -->
                <span class="mb-3 inline-flex justify-center items-center size-8 md:size-10 rounded-lg bg-white text-gray-700 shadow">
                    <svg class="flex-shrink-0 size-4 md:size-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none">
                        <path d="M22 21L12 3L2 21H22Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                        <path d="M12 15L12 10M12 16.5L12 18" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                    </svg>
                </span>
                <!-- End Icon -->
            </div>
            <!-- End Header -->

            <div class="grid sm:flex sm:justify-between sm:items-center gap-1 sm:gap-3">
                <h2 class="text-sm md:text-base text-gray-800">
                    Deal Jacket Rating
                </h2>
                <h3 class="text-lg md:text-2xl font-semibold text-gray-800">
                    {{ $this->rating() }}
                </h3>
            </div>
        </a>
    </div>
</div>
