<div class="border rounded-md p-3">
    <h2 class="text-sm font-semibold leading-6 text-gray-900">Send Contract for Review</h2>
    <form wire:submit.prevent="sendContract" class="sm:flex sm:items-center mt-2" data-np-autofill-form-type="identity" data-np-checked="1" data-np-watching="1">
        <div class="w-full sm:max-w-xs">
            <label for="email" class="sr-only">Email</label>
            <input wire:model.defer="sendEmailAddress" type="email" name="email" id="email" class="block w-full rounded-l-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6" placeholder="you@example.com" required="" data-np-autofill-field-type="email" data-np-uid="5aa4e6a2-4c39-4ad5-9190-8d68f7b810ee">
        </div>
        <button type="submit" class="mt-3 -ml-1 inline-flex w-full items-center justify-center rounded-r-md bg-arm-blue-800 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-arm-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-arm-blue-600 sm:mt-0 sm:w-auto">Send</button>
    </form>
</div>
