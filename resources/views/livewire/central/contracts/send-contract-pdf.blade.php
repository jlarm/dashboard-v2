<div class="border rounded-md p-3">
    <div class="flex items-center gap-3">
        <h2 class="text-sm font-semibold leading-6 text-gray-900">Send PDF Contract</h2>
        <svg wire:loading wire:target="sendContractPdf" class="animate-spin -ml-1 mr-3 h-4 w-4 text-arm-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    </div>
    <form wire:submit.prevent="sendContractPdf" class="sm:flex sm:items-center mt-2" data-np-autofill-form-type="identity" data-np-checked="1" data-np-watching="1">
        <div class="w-full sm:max-w-xs">
            <label for="email" class="sr-only">Email</label>
            <input wire:model.defer="sendPdfEmailAddress" type="email" name="email" id="email" class="block w-full rounded-l-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6" placeholder="you@example.com" required="" data-np-autofill-field-type="email" data-np-uid="5aa4e6a2-4c39-4ad5-9190-8d68f7b810ee">
        </div>
        <button type="submit" class="mt-3 -ml-1 inline-flex w-full items-center justify-center rounded-r-md bg-arm-blue-800 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-arm-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-arm-blue-600 sm:mt-0 sm:w-auto">Send</button>
    </form>
</div>
