<x-wire-elements-pro::tailwind.modal on-submit="create" :content-padding="true">

    <x-slot name="title">Add Employee</x-slot>
    <div class="space-y-5">
        <!-- Name -->
        <div class="col-span-3">
            <x-input-label for="name" :value="__('Employee Name')"/>
            <x-text-input wire:model.defer="name" id="name" class="block mt-1 w-full" type="text" name="name"
                          :value="old('name')" required/>
            @error('name') <p class="text-red-500">{{ $message }}</p> @enderror
        </div>

        <!-- Email Address -->
        <div class="col-span-3">
            <x-input-label for="email" :value="__('Employee Email Address')"/>
            <x-text-input wire:model.defer="email" id="email" class="block mt-1 w-full" type="email" name="email"
                          :value="old('email')" required/>
            @error('email') <p class="text-red-500">{{ $message }}</p> @enderror
        </div>

        @if($allStore->count() > 1)
            <div class="col-span-3">
                <x-input-label for="stores" :value="__('Select Store(s)')"/>
                <label>
                    <select
                        wire:model.defer="stores"
                        class="w-full border-gray-300 rounded-md mt-1 focus:border-arm-blue-500 focus:ring-arm-blue-500"
                        multiple
                        required
                    >
                        @foreach($allStore as $store)
                            <option value="{{ $store->id }}">{{ $store->name }}</option>
                        @endforeach
                    </select>
                </label>
                @error('stores') <p class="text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
        @elseif($allStore->count() === 1)
            <div class="col-span-3">
                <x-input-label :value="__('Store')"/>
                <p class="mt-1 text-sm text-gray-600">This invite will be assigned to {{ $allStore->first()->name }}.</p>
            </div>
        @endif

        {{--Role--}}
        <div class="col-span-3">
            <x-input-label for="role" :value="__('Select a Role')"/>
            <select
                required
                wire:model.defer="role"
                name="role"
                id="role"
                class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-arm-blue-500 focus:outline-none focus:ring-arm-blue-500 sm:text-sm"
            >
                <option></option>
                <option value="Manager">Manager</option>
                <option value="Employee">Employee</option>
            </select>
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
            wire:click="$emit('modal.close')"
            class="inline-flex items-center justify-center rounded-md border border-arm-blue-600 px-4 py-2 text-sm font-medium text-arm-blue-600 shadow-sm focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2 sm:w-auto"
        >
            Cancel
        </button>
    </x-slot>
</x-wire-elements-pro::tailwind.modal>
