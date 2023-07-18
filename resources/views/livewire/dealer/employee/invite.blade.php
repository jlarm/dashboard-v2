<x-wire-elements-pro::tailwind.modal on-submit="sendInvite" :content-padding="true">

    <x-slot name="title">Add Employee @if($currentStore->name)
            to {{ $currentStore->name }}
        @endif
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

        <input type="hidden" wire:model.defer="currentStoreId" value="{{ $currentStoreId }}"/>

        @can('create-stores')
            @if(tenant('locations'))
                <!-- Store -->
                <div class="col-span-3">
                    <div class="col-span-3">
                        <x-input-label for="dealers" :value="__('Select a Store, Cmd/Ctrl click to select multiple')"/>
                        <select wire:model="dealers" class="w-full" multiple required>
                            @foreach($stores as $store)
                                <option value="{{ $store->id }}">{{ $store->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endif

            <!-- Department -->
            <div class="col-span-3">
                <x-input-label for="department" :value="__('Select a Department')"/>
                <select
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
                <x-input-label for="role" :value="__('Select Role(s)')"/>
                <fieldset class="mt-1">
                    <div class="space-y-2 columns-2">
                        @foreach($allRoles as $role)
                            <div
                                class="@if($qiCount && $role['name'] === 'Qualified Individual') hidden @endif relative flex items-start">
                                <div class="flex h-6 items-center">
                                    <input
                                        name="role"
                                        wire:model="roles"
                                        value="{{ $role['name'] }}"
                                        id="{{ $role['name'] }}"
                                        type="checkbox"
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
        @endcan

        {{--Manager list--}}
        @cannot('create-stores')
            <div class="col-span-3">
                <x-input-label for="role" :value="__('Select a Role')"/>
                <select
                    wire:model.defer="role"
                    name="role"
                    id="role"
                    class="@if($qiCount && $role['name'] === 'Qualified Individual') hidden @endif mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-arm-blue-500 focus:outline-none focus:ring-arm-blue-500 sm:text-sm"
                >
                    <option></option>
                    <option value="Manager">Manager</option>
                    <option value="Employee">Employee</option>
                </select>
            </div>
        @endcannot

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
