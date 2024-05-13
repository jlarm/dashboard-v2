<div class="border rounded-md p-3">
    <h2 class="text-sm font-semibold leading-6 text-gray-900">Send Contract for Review</h2>
    <div class="sm:flex sm:items-center mt-2">
        <div class="w-full sm:max-w-xs">
            <label for="email" class="sr-only">Email</label>
            <input wire:model.defer="emailAddress" type="email" name="email" id="email" class="block w-full rounded-l-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6" placeholder="you@example.com" required="" data-np-autofill-field-type="email" data-np-uid="5aa4e6a2-4c39-4ad5-9190-8d68f7b810ee">
        </div>
        <button wire:click.defer="addEmailAddress" type="submit" class="mt-3 -ml-1 inline-flex w-full items-center justify-center rounded-r-md bg-gray-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-arm-blue-600 sm:mt-0 sm:w-auto">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" color="#ffffff" fill="none">
                <path d="M12 7V17M17 12H7" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                <path d="M22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22C17.5228 22 22 17.5228 22 12Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
            </svg>
        </button>
    </div>
        @error('emailAddress') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
    <div>
        <ul role="list" class="divide-y divide-gray-200 my-3">
            @foreach($emailAddresses as $key => $email)
                <li class="p-2 text-sm text-gray-600 flex justify-between items-center">{{ $email }}
                    <button wire:click.prevent="removeEmailAddress({{$key}})" class="bg-red-600 p-1 rounded-md hover:bg-red-800">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="10" height="10" color="#ffffff" fill="none">
                            <path d="M19.0002 4.99994L5.00021 18.9999M5.00021 4.99994L19.0002 18.9999" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                        </svg>
                    </button>
                </li>
            @endforeach
        </ul>
        @if($emailAddresses)
            <div>
                <x-primary-button wire:click.defer="sendContract">send</x-primary-button>
            </div>
        @endif
    </div>
</div>
