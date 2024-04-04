<div>
    @if($error)
        <div class="rounded-md bg-red-50 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">There was an issue with the connection.</h3>
                </div>
            </div>
        </div>
    @else
        <div class="max-w-3xl mx-auto">
            <form wire:submit.prevent="create" class="space-y-8">
                <div>
                    <x-input-label for="name" :value="__('Campaign Name')" />
                    <x-text-input wire:model.defer="name" id="name" class="block mt-1 w-full" type="text" name="name" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="date" :value="__('Schedule Date')" />
                    <x-text-input wire:model.defer="date" id="date" class="block mt-1 w-full" type="date" name="datetime-local" autofocus autocomplete="date" />
                    <p class="mt-2 text-sm text-gray-500" id="email-description">If you would like to run the simulation immediately leave the date field blank.</p>
                    <x-input-error :messages="$errors->get('date')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="name" :value="__('Sending Group')" />
                    <select wire:model.defer="group" class="mt-1 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-arm-blue-600 sm:text-sm sm:leading-6">
                            <option selected></option>
                        @foreach($groups as $group)
                            <option value="{{ $group['name'] }}">{{ $group['name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <x-input-label for="name" :value="__('Template')" />
                    <select wire:model.defer="template" class="mt-1 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-arm-blue-600 sm:text-sm sm:leading-6">
                        <option></option>
                        @foreach($emails as $email)
                            <option value="{{ $email['name'] }}">{{ $email['name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <x-input-label for="name" :value="__('Sending Profile')" />
                    <select wire:model.defer="smtp" class="mt-1 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-arm-blue-600 sm:text-sm sm:leading-6">
                        @foreach($profiles as $profile)
                            <option selected></option>
                            <option value="{{ $profile['name'] }}">{{ $profile['name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex gap-3">
                    <x-primary-button>Submit</x-primary-button>
                    <a href="{{ route('dealer.phishing.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                        Cancel
                    </a>
                    <svg wire:loading class="animate-spin -ml-1 mr-3 h-5 w-5 text-arm-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
            </form>
        </div>
    @endif
</div>
