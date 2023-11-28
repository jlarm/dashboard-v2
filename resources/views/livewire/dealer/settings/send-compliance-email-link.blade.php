<div class="mt-5 pt-5 border-t">
    <div class="mt-2 max-w-xl text-sm text-gray-500">
        <p>Send an email an employee containing a link to this form, requesting them to complete it.</p>
    </div>
    <form wire:submit.prevent="sendEmail" class="mt-3 sm:flex sm:items-center">
        <div class="w-full sm:max-w-xs">
            <label for="email" class="sr-only">Email</label>
            <input wire:model.defer="email" type="email" name="email" id="email" class="block w-full rounded-l-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6" placeholder="you@example.com" required>
        </div>
        <button type="submit" class="mt-3 -ml-1 inline-flex w-full items-center justify-center rounded-r-md bg-arm-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-arm-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-arm-blue-600 sm:mt-0 sm:w-auto">Send</button>
    </form>
</div>
