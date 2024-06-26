<div class="hs-tooltip inline-block">
    <button wire:click="download" class="hs-tooltip-toggle size-[30px] inline-flex justify-center items-center gap-x-2 rounded-lg border border-transparent text-gray-500 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-400 focus:outline-none focus:bg-gray-100 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
        <svg wire:loading.remove class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" x2="12" y1="15" y2="3"></line></svg>
        <span wire:loading class="animate-spin inline-block size-4 border-[3px] border-current border-t-transparent text-arm-blue-600 rounded-full dark:text-arm-blue-500" role="status" aria-label="loading">
        <span class="sr-only">Loading...</span>
      </span>
    </button>

    <span class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 inline-block absolute invisible z-20 py-1.5 px-2.5 bg-gray-900 text-xs text-white rounded-lg dark:bg-neutral-700" role="tooltip" data-popper-placement="bottom" style="position: fixed; inset: 0px auto auto 0px; margin: 0px; transform: translate3d(693px, 53px, 0px);">
    Download
  </span>
</div>
