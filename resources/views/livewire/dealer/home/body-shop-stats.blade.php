<div>
    <div class="relative overflow-hidden p-4 sm:p-5 bg-white border border-gray-200 rounded-xl shadow-sm before:absolute before:top-0 before:end-0 before:size-full before:bg-gradient-to-br before:from-{{ $this->ratingColor() }}-100 before:via-transparent before:blur-xl dark:bg-neutral-800 dark:border-neutral-700 dark:before:from-{{ $this->ratingColor() }}-800/30 dark:before:via-transparent">
        <a href="{{ !tenant('locations') ? route('dealer.audit.osha.index') : route('dealer.stores.audits.osha.index', $store) }}" class="relative z-10">
            <!-- Header -->
            <div class="flex justify-between gap-x-3">
                <!-- Icon -->
                <span class="mb-3 inline-flex justify-center items-center size-8 md:size-10 rounded-lg bg-white text-gray-700 shadow dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400">
                    <svg class="flex-shrink-0 size-4 md:size-5 text-{{ $this->ratingColor() }}-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none">
                        <path d="M22 6H2V3H22V6Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                        <path d="M22 6V21M2 6V21" stroke="currentColor" stroke-width="1.5" stroke-linecap="square" stroke-linejoin="round" />
                        <path d="M16 19V21M8 19V21" stroke="currentColor" stroke-width="1.5" stroke-linecap="square" stroke-linejoin="round" />
                        <path d="M7.5 14L9 10H15L16.5 14" stroke="currentColor" stroke-width="1.5" />
                        <path d="M18 14H6V19H18V14Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                        <path d="M8.5 16.49V16.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="square" stroke-linejoin="round" />
                        <path d="M15.5 16.49V16.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="square" stroke-linejoin="round" />
                    </svg>
                </span>
                <!-- End Icon -->
            </div>
            <!-- End Header -->

            <div class="grid sm:flex sm:justify-between sm:items-center gap-1 sm:gap-3">
                <h2 class="text-sm md:text-base text-{{ $this->ratingColor() }}-800">
                    Body Shop Rating
                </h2>
                <h3 class="text-lg md:text-2xl font-semibold text-{{ $this->ratingColor() }}-800">
                    {{ $this->rating() }}
                </h3>
            </div>
        </a>
    </div>
</div>
