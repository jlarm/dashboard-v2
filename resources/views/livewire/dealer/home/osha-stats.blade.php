<div>
    <div class="relative overflow-hidden p-3 bg-white border border-gray-200 rounded-xl shadow-sm before:absolute before:top-0 before:end-0 before:size-full before:bg-gradient-to-br before:from-blue-100 before:via-transparent before:blur-xl">
        <a
            href="{{ !tenant('locations') ? route('dealer.audit.osha.index') : route('dealer.stores.audits.osha.index', $store) }}"
            class="absolute inset-0 z-0"
            aria-label="View OSHA audits"
        ></a>

        <div class="relative z-10 pointer-events-none">
            <div class="flex justify-between items-center gap-x-3 mb-3">
                <span class="inline-flex justify-center items-center size-6 rounded-lg bg-white text-gray-700 shadow">
                    <svg class="flex-shrink-0 size-4 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none">
                        <path d="M22 21L12 3L2 21H22Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                        <path d="M12 15L12 10M12 16.5L12 18" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                    </svg>
                </span>
                @if($this->progress() !== null)
                    @if($this->progress()[0] === 'positive')
                        <span class="flex-shrink-0 py-1 px-1.5 inline-flex items-center gap-x-1 text-xs font-medium bg-teal-100 text-teal-800 rounded-full">
                          <svg class="w-3 h-3" width="16" height="16" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M9.39508 12.4435C9.39508 12.5911 9.45413 12.7326 9.55924 12.837C9.66436 12.9414 9.80692 13 9.95557 13H14.4395C14.5882 13 14.7307 12.9414 14.8358 12.837C14.9409 12.7326 15 12.5911 15 12.4435V7.99161C15 7.84402 14.9409 7.70247 14.8358 7.59811C14.7307 7.49375 14.5882 7.43512 14.4395 7.43512C14.2909 7.43512 14.1483 7.49375 14.0432 7.59811C13.9381 7.70247 13.879 7.84402 13.879 7.99161V10.8853L9.8289 5.96933C9.77932 5.90924 9.71762 5.86013 9.64777 5.82515C9.57792 5.79017 9.50146 5.77009 9.42333 5.76621C9.34519 5.76233 9.2671 5.77474 9.19409 5.80263C9.12107 5.83052 9.05474 5.87327 8.99937 5.92815L6.09939 8.80742L2.00107 3.21249C1.91141 3.0993 1.78106 3.02502 1.6374 3.00527C1.49374 2.98551 1.34796 3.02181 1.2307 3.10653C1.11343 3.19126 1.03381 3.31782 1.00856 3.45962C0.983313 3.60142 1.01441 3.74741 1.09531 3.86692L5.57925 9.98829C5.62684 10.0534 5.68808 10.1075 5.75875 10.1468C5.82942 10.1861 5.90784 10.2098 5.9886 10.2161C6.06936 10.2225 6.15055 10.2114 6.22657 10.1836C6.30259 10.1557 6.37164 10.1119 6.42895 10.0551L9.3536 7.1502L13.2569 11.887H9.95557C9.80692 11.887 9.66436 11.9457 9.55924 12.05C9.45413 12.1544 9.39508 12.2959 9.39508 12.4435Z"></path>
                          </svg>
                          {{ $this->progress()[1] }}
                        </span>
                    @else
                        <span class="flex-shrink-0 py-1 px-1.5 inline-flex items-center gap-x-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">
                          <svg class="w-3 h-3" width="16" height="16" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M9.39508 3.55649C9.39508 3.4089 9.45413 3.26735 9.55924 3.16299C9.66436 3.05863 9.80692 3 9.95557 3H14.4395C14.5882 3 14.7307 3.05863 14.8358 3.16299C14.9409 3.26735 15 3.4089 15 3.55649V8.00839C15 8.15598 14.9409 8.29753 14.8358 8.40189C14.7307 8.50625 14.5882 8.56488 14.4395 8.56488C14.2909 8.56488 14.1483 8.50625 14.0432 8.40189C13.9381 8.29753 13.879 8.15598 13.879 8.00839V5.11465L9.8289 10.0307C9.77932 10.0908 9.71762 10.1399 9.64777 10.1749C9.57792 10.2098 9.50146 10.2299 9.42333 10.2338C9.34519 10.2377 9.2671 10.2253 9.19409 10.1974C9.12107 10.1695 9.05474 10.1267 8.99937 10.0719L6.09939 7.19258L2.00107 12.7875C1.91141 12.9007 1.78106 12.975 1.6374 12.9947C1.49374 13.0145 1.34796 12.9782 1.2307 12.8935C1.11343 12.8087 1.03381 12.6822 1.00856 12.5404C0.983313 12.3986 1.01441 12.2526 1.09531 12.1331L5.57925 6.01171C5.62684 5.94662 5.68808 5.89254 5.75875 5.85321C5.82942 5.81388 5.90784 5.79022 5.9886 5.78388C6.06936 5.77753 6.15055 5.78864 6.22657 5.81645C6.30259 5.84425 6.37164 5.88809 6.42895 5.94493L9.3536 8.8498L13.2569 4.11298H9.95557C9.80692 4.11298 9.66436 4.05435 9.55924 3.94998C9.45413 3.84562 9.39508 3.70408 9.39508 3.55649Z"></path>
                          </svg>
                          {{ $this->progress()[1] }}
                        </span>
                    @endif
                @endif
            </div>
            <!-- End Header -->

            <h2 class="text-sm text-gray-800">
                OSHA Rating
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-2 mt-2">
                <h3 class="text-base font-semibold text-gray-800">
                    {{ $this->rating() }}
                </h3>
                @if($this->pdfPath())
                    <div class="pointer-events-auto">
                        <x-armp.button wire:click.stop="downloadPdf" type="button" size="xs" class="w-full">
                            <span wire:loading.remove wire:target="downloadPdf">Download Report</span>
                            <span wire:loading.inline-flex wire:target="downloadPdf" class="flex-row items-center justify-center gap-1 whitespace-nowrap leading-none">
                                <x-loading-icon class="!-ml-0 !mr-0 !size-2 shrink-0" />
                                <span class="inline-block">Loading...</span>
                            </span>
                        </x-armp.button>
                    </div>
                @else
                    <div class="hidden md:block h-7"></div>
                @endif
            </div>
        </div>
    </div>
</div>
