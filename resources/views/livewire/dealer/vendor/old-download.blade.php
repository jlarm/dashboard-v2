<button {{ $vendor->signature ? '' : 'disabled' }} wire:click="download" type="button" class="size-7 inline-flex justify-center items-center gap-x-2 rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:bg-gray-50">
    <svg wire:loading.remove class="flex-shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
    <span wire:loading class="animate-spin inline-block size-4 border-[3px] border-current border-t-transparent text-arm-blue-600 rounded-full" role="status" aria-label="loading">
        <span class="sr-only">Loading...</span>
      </span>
</button>
