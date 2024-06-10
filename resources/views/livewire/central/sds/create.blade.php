<div class="p-6">
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-xl font-bold leading-none tracking-tight text-neutral-900">Add SDS Sheet</h1>
        </div>
    </div>
    <form wire:submit.prevent="create" class="max-w-3xl mx-auto space-y-5 mt-8" @keydown.enter.prevent>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
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
            <!-- Product Identification Number -->
            <div class="space-y-3">
                <div>
                    <x-input-label for="pin" class="mb-1" :value="__('Product Identification Number(s)')"/>
                    <div class="flex rounded-lg">
                        <input
                            class="border-gray-300 focus:border-arm-blue-500 focus:ring-arm-blue-500 rounded-s-md block w-full"
                            wire:model="newPin"
                            wire:keydown.enter="addPin"
                            type="text"
                            id="pin"
                        >
                        <button wire:click="addPin" type="button" class="py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-e-md border border-gray-300 border-l-0 bg-white text-white hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" color="#666" fill="none">
                                <path d="M12 4V20M20 12H4" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="flex flex-wrap justify-start items-center gap-3">
                    @foreach ($productIdentificationNumbers as $index => $pin)
                        <span class="p-1 ps-2 inline-flex items-center gap-1.5 bg-arm-blue-500 text-white text-xs rounded-full">
                    {{ $pin }}
                    <button type="button" wire:click="removePin({{ $index }})" class="inline-flex flex-shrink-0 justify-center items-center size-5 ms-1 rounded-full text-gray-800 bg-gray-200 hover:bg-gray-300 focus:outline-none focus:bg-gray-300 text-sm">
                      <svg class="flex-shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 6 6 18"></path>
                        <path d="m6 6 12 12"></path>
                      </svg>
                    </button>
                  </span>
                    @endforeach
                </div>
            </div>
            <!-- CAS Number -->
            <div class="space-y-3">
                <div>
                    <x-input-label for="cas" class="mb-1" :value="__('CAS Number(s)')"/>
                    <div class="flex rounded-lg">
                        <input
                            class="border-gray-300 focus:border-arm-blue-500 focus:ring-arm-blue-500 rounded-s-md block w-full"
                            wire:model="newCasNo"
                            wire:keydown.enter="addCas"
                            type="text"
                            id="cas"
                        >
                        <button wire:click="addCas" type="button" class="py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-e-md border border-gray-300 border-l-0 bg-white text-white hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" color="#666" fill="none">
                                <path d="M12 4V20M20 12H4" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="flex flex-wrap justify-start items-center gap-3">
                    @foreach ($casNos as $index => $cas)
                        <span class="p-1 ps-2 inline-flex items-center gap-1.5 bg-arm-blue-500 text-white text-xs rounded-full">
                    {{ $cas }}
                    <button type="button" wire:click="removeCas({{ $index }})" class="inline-flex flex-shrink-0 justify-center items-center size-5 ms-1 rounded-full text-gray-800 bg-gray-200 hover:bg-gray-300 focus:outline-none focus:bg-gray-300 text-sm">
                      <svg class="flex-shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 6 6 18"></path>
                        <path d="m6 6 12 12"></path>
                      </svg>
                    </button>
                  </span>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- File Upload -->
        <div class="flex justify-start items-baseline gap-3 border rounded-md p-3">
            <label for="file" class="hover:cursor-pointer">
                <div class="py-1 px-2 inline-flex items-center gap-x-2 text-xs font-medium rounded-md border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none">
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
</div>
