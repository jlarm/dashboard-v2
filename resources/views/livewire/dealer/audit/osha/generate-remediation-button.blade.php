<button wire:click="downloadPdf" class="group w-full flex items-center gap-3 rounded-md px-3 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" class="text-gray-400 group-hover:text-gray-500" fill="none">
        <path d="M4 15L4 18C4 19.1046 4.89543 20 6 20L18 20C19.1046 20 20 19.1046 20 18V15" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M11 5H3V21H19V13" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
        <path d="M12 3L12 14M12 14L15.5 10.5M12 14L8.5 10.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
    <span>Download Remediation PDF</span>
    <svg wire:loading wire:target="download" class="animate-spin ml-auto h-4 w-4 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
    </svg>
</button>