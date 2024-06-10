<form wire:submit.prevent="create" class="max-w-3xl mx-auto space-y-5 mt-8" @keydown.enter.prevent>
    <!-- Name -->
    <div>
        <x-input-label for="name" :value="__('Name')"/>
        <x-text-input
            wire:model.defer="name"
            id="name"
            class="block mt-1 w-full"
            type="text"
            name="name"
            :value="old('name')"
            required
        />
        <x-input-error :messages="$errors->get('name')" class="mt-2"/>
    </div>
    <!-- Product Identifier -->
    <div>
        <x-input-label for="productIdentifier" :value="__('Product Identifier')"/>
        <x-text-input
            wire:model.defer="productIdentifier"
            id="productIdentifier"
            class="block mt-1 w-full"
            type="text"
            name="productIdentifier"
            :value="old('productIdentifier')"
        />
        <x-input-error :messages="$errors->get('productIdentifier')" class="mt-2"/>
    </div>
    <!-- Product Identification Numbers -->
    <div class="space-y-3">
        <div>
            <x-input-label for="pin" :value="__('Product Identification Number(s)')"/>
            <x-text-input
                wire:model="newPin"
                wire:keydown.enter="addPin"
                class="block mt-1 w-full"
                type="text"
                id="pin"
            />
            <p class="mt-2 text-sm text-gray-500">Hit the enter key to add a PIN.</p>
        </div>
        <div class="flex flex-wrap justify-start items-center gap-3">
            @if(!empty($productIdentificationNumbers))
            @foreach ($productIdentificationNumbers as $index => $pin)
                <span class="p-1 ps-2 inline-flex items-center gap-1.5 bg-white border border-gray-200 text-gray-800 text-xs rounded-full dark:bg-neutral-800 dark:text-neutral-200 dark:border-neutral-700">
                    {{ $pin }}
                    <button type="button" wire:click="removePin({{ $index }})" class="inline-flex flex-shrink-0 justify-center items-center size-5 ms-1 rounded-full text-gray-800 bg-gray-200 hover:bg-gray-300 focus:outline-none focus:bg-gray-300 text-sm dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:focus:bg-neutral-600 dark:text-neutral-400">
                      <svg class="flex-shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 6 6 18"></path>
                        <path d="m6 6 12 12"></path>
                      </svg>
                    </button>
                  </span>
            @endforeach
            @endif
        </div>
    </div>
    <!-- CAS Numbers -->
{{--    <div class="space-y-3">--}}
{{--        <div>--}}
{{--            <x-input-label for="cas" :value="__('CAS Number(s)')"/>--}}
{{--            <x-text-input--}}
{{--                wire:model="newCasNo"--}}
{{--                wire:keydown.enter="addCas"--}}
{{--                class="block mt-1 w-full"--}}
{{--                type="text"--}}
{{--                id="cas"--}}
{{--            />--}}
{{--            <p class="mt-2 text-sm text-gray-500">Hit the enter key to add a CAS.</p>--}}
{{--        </div>--}}
{{--        <div class="flex flex-wrap justify-start items-center gap-3">--}}
{{--            @foreach ($casNos as $index => $cas)--}}
{{--                <span class="p-1 ps-2 inline-flex items-center gap-1.5 bg-white border border-gray-200 text-gray-800 text-xs rounded-full dark:bg-neutral-800 dark:text-neutral-200 dark:border-neutral-700">--}}
{{--                    {{ $cas }}--}}
{{--                    <button type="button" wire:click="removeCas({{ $index }})" class="inline-flex flex-shrink-0 justify-center items-center size-5 ms-1 rounded-full text-gray-800 bg-gray-200 hover:bg-gray-300 focus:outline-none focus:bg-gray-300 text-sm dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:focus:bg-neutral-600 dark:text-neutral-400">--}}
{{--                      <svg class="flex-shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">--}}
{{--                        <path d="M18 6 6 18"></path>--}}
{{--                        <path d="m6 6 12 12"></path>--}}
{{--                      </svg>--}}
{{--                    </button>--}}
{{--                  </span>--}}
{{--            @endforeach--}}
{{--        </div>--}}
{{--    </div>--}}
    <!-- Manufacturer -->
    <div>
        <x-input-label for="manufacturer" :value="__('Manufacturer')"/>
        <x-text-input
            wire:model.defer="manufacturer"
            id="manufacturer"
            class="block mt-1 w-full"
            type="text"
            name="manufacturer"
            :value="old('manufacturer')"
        />
        <x-input-error :messages="$errors->get('manufacturer')" class="mt-2"/>
    </div>
    <!-- Common Name -->
    <div>
        <x-input-label for="commonName" :value="__('Common Name')"/>
        <x-text-input
            wire:model.defer="commonName"
            id="commonName"
            class="block mt-1 w-full"
            type="text"
            name="commonName"
            :value="old('commonName')"
        />
        <x-input-error :messages="$errors->get('commonName')" class="mt-2"/>
    </div>
    <!-- File Upload -->
    <div class="flex justify-start items-baseline gap-3 border border-gray-300 rounded-md p-3">
        <label for="file" class="hover:cursor-pointer">
            <div class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none">
                Select PDF
            </div>
            <input class="sr-only" id="file" type="file" wire:model="file" />
        </label>
        @if($file)
            <p class="block text-xs text-gray-500 mt-2">{{ $file->getClientOriginalName() }}</p>
        @endif
    </div>
    <x-primary-button wire:loading.attr="disabled" wire:loading.class="opacity-25" wire:target="create">
        Submit
        <svg wire:loading wire:target="create" class="animate-spin ml-1 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
             fill="none"
             viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor"
                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    </x-primary-button>
    <x-button.secondary href="{{ route('sds.index') }}">Cancel</x-button.secondary>
</form>
