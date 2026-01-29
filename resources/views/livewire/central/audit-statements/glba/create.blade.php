<div class="bg-white rounded-md p-6 flex flex-col space-y-5">
    <div>
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-xl font-bold leading-none tracking-tight text-neutral-900">Create GLBA Violation Statement</h1>
            </div>
        </div>
        <div class="mt-8 flow-root">
            <form wire:submit.prevent="create" x-data @keydown.enter.prevent class="max-w-3xl mx-auto space-y-5">
                <div>
                    <x-input-label for="statement" :value="__('Violation Statement')"/>
                    <x-text-input
                        wire:model.defer="statement"
                        id="statement"
                        class="block mt-1 w-full"
                        type="text"
                        name="statement"
                        :value="old('statement')"
                        required
                        autofocus
                    />
                    <x-input-error :messages="$errors->get('statement')" class="mt-2"/>
                </div>
                <div>
                    <x-input-label for="weight" :value="__('Weight')" />
                    <x-select wire:model.defer="weight" id="weight" class="mt-1">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </x-select>
                    <x-input-error :messages="$errors->get('weight')" class="mt-2"/>
                </div>
                <div class="space-y-3">
                    <div>
                        <x-input-label for="keyword" :value="__('Add Keywords')"/>
                        <x-text-input
                            wire:model="newKeyword"
                            wire:keydown.enter="addKeyword"
                            class="block mt-1 w-full"
                            type="text"
                        />
                        <p class="mt-2 text-sm text-gray-500" id="email-description">Hit the enter key to add a keyword.</p>
                    </div>
                    <div class="flex gap-2">
                        @foreach ($keywords as $index => $keyword)
                            <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                                {{ $keyword }}
                                <button type="button" wire:click="removeKeyword({{ $index }})" class="text-blue-700 ml-2">
                                    &times;
                                </button>
                            </span>
                        @endforeach
                    </div>
                    <div>
                        <x-primary-button>Submit</x-primary-button>
                        <x-button.secondary href="{{ route('glba-violations.index') }}">Cancel</x-button.secondary>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
