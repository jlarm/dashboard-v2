<x-wire-elements-pro::tailwind.slide-over on-submit="updateUser">
    <x-slot name="title">Edit</x-slot>
    <div class="mb-3">
        @foreach($errors->all() as $error)
            <div class="text-red-500">{{ $error }}</div>
        @endforeach
    </div>
        <div class="space-y-10">
        <!-- Store -->
        @if(tenant('locations'))
            <div class="col-span-3">
                <div class="col-span-3">
                    <x-input-label for="dealers" :value="__('Select Store(s)')"/>
                    @foreach($stores as $store)
                        <div class="relative flex items-start max-h-32 overscroll-y-auto">
                            <div class="flex h-6 items-center">
                                <input
                                    wire:model="assignedStores"
                                    {{ in_array($store->name, $assignedStores) ? 'checked' : '' }}
                                    value="{{ $store->name }}"
                                    id="{{ $store->name }}"
                                    aria-describedby="{{ $store->name }}"
                                    name="{{ $store->name }}"
                                    type="checkbox"
                                    class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"/>
                            </div>
                            <div class="ml-3 text-sm leading-6">
                                <label for="{{ $store->name }}" class="text-gray-900">{{ $store->name }}</label>
                            </div>
                        </div>
                    @endforeach
                </div>
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
                        class="relative flex items-start">
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

    @can('create-stores')
    <div class="relative flex items-start border-y py-5 mt-5">
        <div class="flex h-6 items-center">
            <input wire:model.defer="qi" id="qi" name="qi" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
        </div>
        <div class="ml-3 text-sm leading-6">
            <label for="qi" class="font-medium text-gray-900">Qualified Individual</label>
        </div>
    </div>
    @endcan


    @if($user->can('create-users') && $remediationRemindersActive)
        <div>
            <x-input-label :value="__('Remediation Reminders')" class="mt-5"/>
            <ul class="max-w-sm flex flex-col mt-1">
                @foreach(\App\Enums\AuditTypes::cases() as $type)
                    <li class="inline-flex items-center gap-x-2 py-3 px-4 text-sm font-medium bg-white border border-gray-200 text-gray-800 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg">
                        <div class="relative flex items-start w-full">
                            <div class="flex items-center h-5">
                                <input id="{{ $type->value }}" wire:model="selectedAuditTypes" value="{{ $type->value }}" name="{{ $type->value }}" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                            </div>
                            <label for="{{ $type->value }}" class="ms-3.5 block w-full text-sm text-gray-600">
                                {{ $type->label() }}
                            </label>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

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
