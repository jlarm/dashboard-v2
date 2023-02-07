<x-wire-elements-pro::tailwind.modal on-submit="sendInvite" :content-padding="true">

    <x-slot name="title">Add Employee</x-slot>

    <div class="space-y-5">
        <!-- Name -->
        <div class="col-span-3">
            <x-input-label for="name" :value="__('Employee Name')"/>
            <x-text-input wire:model.defer="name" id="name" class="block mt-1 w-full" type="text" name="name"
                          :value="old('name')" required/>
            <x-input-error :messages="$errors->get('name')" class="mt-2"/>
        </div>

        <!-- Email Address -->
        <div class="col-span-3">
            <x-input-label for="email" :value="__('Employee Email Address')"/>
            <x-text-input wire:model.defer="email" id="email" class="block mt-1 w-full" type="email" name="email"
                          :value="old('email')" required/>
            <x-input-error :messages="$errors->get('email')" class="mt-2"/>
        </div>

        @can('create-stores')
            <!-- Store -->
            @if($stores->count())
                <div class="col-span-3">
                    <x-input-label for="store_id" :value="__('Select a Store')"/>
                    <select
                        wire:model.defer="store"
                        name="store"
                        id="store"
                        class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-arm-blue-500 focus:outline-none focus:ring-arm-blue-500 sm:text-sm"
                    >
                        <option></option>
                        @foreach($stores as $store)
                            <option value="{{ $store->id }}">{{ $store->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
            <!-- Department -->
            <div class="col-span-3">
                <x-input-label for="department" :value="__('Select a Department')"/>
                <select
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
        @endcan

        <!-- Role -->
        <div class="col-span-3">
            <x-input-label for="role" :value="__('Select a Role')"/>
            <select
                wire:model.defer="role"
                name="role"
                id="role"
                class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-arm-blue-500 focus:outline-none focus:ring-arm-blue-500 sm:text-sm"
            >
                <option></option>
                @role('Consultant')
                <option value="Owner">Owner</option>
                <option value="Manager">Manager</option>
                <option value="Employee">Employee</option>
                @endrole
                @role('Owner')
                <option value="Manager">Manager</option>
                <option value="Employee">Employee</option>
                @endrole
                @role('Manager')
                {{--                <option value="Employee">Employee</option>--}}
                @endrole
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
