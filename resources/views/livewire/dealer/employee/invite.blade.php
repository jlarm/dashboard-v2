<x-wire-elements-pro::tailwind.modal on-submit="sendInvite" :content-padding="true">

    <x-slot name="title">Add Employee
    </x-slot>
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

        <!-- Stores -->
        @if(tenant('locations'))
            <div class="col-span-3">
                <div class="col-span-3">
                    <x-input-label for="stores" :value="__('Select a Store, Cmd/Ctrl click to select multiple')"/>
                    <label>
                        <select wire:model.defer="stores"
                                class="w-full border-gray-300 rounded-md mt-1 focus:border-arm-blue-500 focus:ring-arm-blue-500"
                                multiple required>
                            @foreach($allStore as $store)
                                <option value="{{ $store->id }}">{{ $store->name }}</option>
                            @endforeach
                        </select>
                    </label>
                </div>
            </div>
        @endif

        <!-- Department -->
        <div class="col-span-3">
            <x-input-label for="department" :value="__('Select a Department')"/>
            <label for="department"></label><select
                required
                wire:model.defer="department"
                name="department"
                id="department"
                class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-arm-blue-500 focus:outline-none focus:ring-arm-blue-500 sm:text-sm"
            >
                <option></option>
                @foreach($departments as $department)
                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Role -->
        <div class="col-span-3">
            <x-input-label for="role" :value="__('Select Role')"/>
            <fieldset class="mt-1">
                <div class="space-y-2 columns-2">
                    @foreach($allRoles as $role)
                        <div
                            class="relative flex items-start">
                            <div class="flex h-6 items-center">
                                <input
                                    name="role"
                                    wire:model.defer="role"
                                    value="{{ $role['name'] }}"
                                    id="{{ $role['name'] }}"
                                    type="radio"
                                    class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                            </div>
                            <div class="ml-3 text-sm leading-6">
                                <label for="{{ $role['name'] }}"
                                       class="text-gray-900">{{ $role['name'] }}</label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </fieldset>
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
