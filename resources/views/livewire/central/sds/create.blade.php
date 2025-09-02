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
            <!-- Keywords -->
            <div class="space-y-3 col-span-full">
                <div>
                    <x-input-label for="keywords" :value="__('Keywords')" />
                    <div class="flex rounded-lg">
                        <input
                            wire:model="newKeyword"
                            wire:keydown.tab="addKeyword"
                            wire:keydown.enter="addKeyword"
                            class="border-gray-300 focus:border-arm-blue-500 focus:ring-arm-blue-500 rounded-s-md block w-full"
                            type="text"
                            id="keywords"
                            placeholder="Type keyword and press Tab or Enter"
                        />
                        <button
                            wire:click="addKeyword"
                            type="button"
                            class="py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-e-md border border-gray-300 border-l-0 bg-white text-gray-600 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" color="currentColor" fill="none">
                                <path d="M12 4V20M20 12H4" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('keywords')" class="mt-2"/>
                </div>

                <!-- Keywords Display -->
                <div class="flex flex-wrap justify-start items-center gap-3">
                    @foreach ($keywords as $index => $keyword)
                        <span class="inline-flex items-center gap-x-1.5 py-1.5 ps-3 pe-2 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ $keyword }}
                            <button
                                wire:click="removeKeyword({{ $index }})"
                                type="button"
                                class="shrink-0 size-4 inline-flex items-center justify-center rounded-full hover:bg-blue-200 focus:outline-none focus:bg-blue-200 focus:text-blue-500"
                            >
                                <svg class="shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
                <input class="sr-only" id="file" type="file" wire:model.defer="file" />
            </label>
            <div>
                <svg wire:loading wire:target="file" class="animate-spin ml-1 h-5 w-5 text-arm-blue-500" xmlns="http://www.w3.org/2000/svg"
                     fill="none"
                     viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
            @if($file)
                <p class="block text-xs text-gray-500 mt-2">{{ $file->getClientOriginalName() }}</p>
            @endif
            <x-input-error :messages="$errors->get('file')" class="mt-2"/>
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
