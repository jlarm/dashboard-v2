<x-wire-elements-pro::tailwind.slide-over on-submit="sendInvite">
    <x-slot name="title">Add Employee</x-slot>

    <div class="space-y-6 pb-6">
        {{-- Name --}}
        <div>
            <x-input-label for="name" :value="__('Employee Name')" />
            <x-text-input wire:model.defer="name" id="name" class="block mt-1 w-full" type="text" name="name" required />
            @error('name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
        </div>

        {{-- Email --}}
        <div>
            <x-input-label for="email" :value="__('Employee Email Address')" />
            <x-text-input wire:model.defer="email" id="email" class="block mt-1 w-full" type="email" name="email" required />
            @error('email') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
        </div>

        {{-- Stores --}}
        @if($allStore->count() > 1)
            @php
                $storeOptions = $allStore->values()->map(fn ($s) => ['id' => $s->id, 'name' => $s->name])->values();
            @endphp
            <div
                x-data="{
                    selectedStoreIds: [],
                    get primaryOptions() {
                        return @js($storeOptions).filter(s => this.selectedStoreIds.includes(s.id));
                    }
                }"
                @click="$nextTick(() => {
                    selectedStoreIds = [...$el.querySelectorAll('[data-armp-select] [data-option-value][aria-selected=true]')]
                        .map(el => Number(el.dataset.optionValue));
                })"
            >
                <x-armp.select
                    variant="listbox"
                    multiple
                    searchable
                    wire:model="stores"
                    label="{{ __('Select Store(s)') }}"
                    placeholder="Choose stores..."
                >
                    @foreach($allStore as $store)
                        <x-armp.select.option value="{{ $store->id }}">{{ $store->name }}</x-armp.select.option>
                    @endforeach
                </x-armp.select>
                @error('stores') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror

                {{-- Primary Store --}}
                <div x-show="selectedStoreIds.length > 1" x-cloak class="mt-4">
                    <x-input-label for="primaryStoreId" :value="__('Primary Store')" />
                    <select
                        wire:model.defer="primaryStoreId"
                        id="primaryStoreId"
                        name="primaryStoreId"
                        required
                        class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-arm-blue-500 focus:outline-none focus:ring-arm-blue-500 sm:text-sm"
                    >
                        <option value="">{{ __('Choose a primary store...') }}</option>
                        <template x-for="store in primaryOptions" :key="store.id">
                            <option :value="store.id" x-text="store.name"></option>
                        </template>
                    </select>
                    @error('primaryStoreId') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>
        @elseif($allStore->count() === 1)
            <div>
                <x-input-label :value="__('Store')" />
                <p class="mt-1 text-sm text-gray-600">This invite will be assigned to {{ $allStore->first()->name }}.</p>
            </div>
        @endif

        {{-- Department --}}
        <div>
            <x-armp.select
                variant="listbox"
                wire:model.defer="department"
                label="{{ __('Select a Department') }}"
                placeholder="Choose a department..."
            >
                @foreach($departments as $department)
                    <x-armp.select.option value="{{ $department->id }}">{{ $department->name }}</x-armp.select.option>
                @endforeach
            </x-armp.select>
            @error('department') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
        </div>

        {{-- Role --}}
        <div>
            <x-armp.select
                variant="listbox"
                wire:model.defer="role"
                label="{{ __('Select Role') }}"
                placeholder="Choose a role..."
            >
                @foreach($allRoles as $role)
                    <x-armp.select.option value="{{ $role->name }}">{{ $role->name }}</x-armp.select.option>
                @endforeach
            </x-armp.select>
            @error('role') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
        </div>
    </div>

    <x-slot name="buttons">
        <button
            type="submit"
            class="inline-flex items-center justify-center rounded-md border border-transparent bg-arm-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-arm-blue-700 focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2 sm:w-auto"
        >
            Submit
        </button>
        <button
            type="button"
            wire:click="$emit('slide-over.close')"
            class="inline-flex items-center justify-center rounded-md border border-arm-blue-600 px-4 py-2 text-sm font-medium text-arm-blue-600 shadow-sm focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2 sm:w-auto"
        >
            Cancel
        </button>
    </x-slot>
</x-wire-elements-pro::tailwind.slide-over>
