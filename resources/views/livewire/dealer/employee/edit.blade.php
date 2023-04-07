<x-wire-elements-pro::tailwind.slide-over on-submit="updateUser">
    <x-slot name="title">Edit</x-slot>

    <div class="space-y-5">
        <!-- Store -->
        @if(tenant('locations'))
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
                @role('super-admin')
                @foreach($roles as $role)
                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                @endforeach
                @endrole
                {{--                @role('Consultant')--}}
                {{--                <option value="Owner">Owner</option>--}}
                {{--                <option value="Manager">Manager</option>--}}
                {{--                <option value="Employee">Employee</option>--}}
                {{--                @endrole--}}
                {{--                @role('Owner')--}}
                {{--                <option value="Manager">Manager</option>--}}
                {{--                <option value="Employee">Employee</option>--}}
                {{--                @endrole--}}
                {{--                @role('Manager')--}}
                {{--                <option value="Employee">Employee</option>--}}
                {{--                @endrole--}}
            </select>
        </div>
    </div>


    <x-slot name="buttons">
        <button
            type="submit"
            class="inline-flex items-center justify-center rounded-md border border-transparent bg-arm-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-arm-blue-700 focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2 sm:w-auto"
        >
            Save Changes
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
