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
        <!-- Roles -->
        <div class="col-span-3">
            <x-input-label for="role" :value="__('Select Role(s)')"/>
            <div class="columns-2">
                @foreach($allRoles as $role)
                    <div
                        class="@if($qiCount && $role['name'] === 'Qualified Individual' && !in_array('Qualified Individual', $assignedRoles)) hidden @endif relative flex items-start">
                        <div class="flex h-6 items-center">
                            <input
                                wire:model="assignedRoles"
                                {{ in_array($role->name, $assignedRoles) ? 'checked' : '' }}
                                value="{{ $role->name }}"
                                id="{{ $role->name }}"
                                aria-describedby="{{ $role->name }}"
                                name="{{ $role->name }}"
                                type="checkbox"
                                class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"/>
                        </div>
                        <div class="ml-3 text-sm leading-6">
                            <label for="{{ $role->name }}" class="text-gray-900">{{ $role->name }}</label>
                        </div>
                    </div>
                @endforeach
            </div>
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
