<x-wire-elements-pro::tailwind.slide-over on-submit="updateUser">
    <x-slot name="title">Edit</x-slot>

    <div class="flex flex-col h-full">
        <div class="flex-1 overflow-y-auto pb-6">
            <div class="mb-3">
                @foreach($errors->all() as $error)
                    <div class="text-red-500">{{ $error }}</div>
                @endforeach
            </div>
            <div class="space-y-10">
                {{-- Store Assignment --}}
                @if($showStoreAssignment)
                    <div class="col-span-3">
                        <x-input-label for="dealers" :value="__('Select Store(s)')" />

                        <div class="mt-2 max-h-32 space-y-2 overflow-y-auto p-1">
                            @foreach($stores as $store)
                                <div class="relative flex items-start">
                                    <div class="flex h-6 items-center">
                                        <input
                                            wire:model="assignedStores"
                                            value="{{ $store->id }}"
                                            id="store-{{ $store->id }}"
                                            aria-describedby="store-{{ $store->id }}-description"
                                            name="assignedStores[]"
                                            type="checkbox"
                                            class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:outline-none focus:ring-2 focus:ring-arm-blue-600 focus:ring-offset-0"
                                        >
                                    </div>
                                    <div class="ml-3 text-sm leading-6">
                                        <label for="store-{{ $store->id }}" class="text-gray-900">
                                            {{ $store->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Primary Store --}}
                        @if(count($assignedStores) > 1)
                            <div class="mt-4">
                                <x-input-label for="primaryStoreId" :value="__('Primary Store')" />

                                <select
                                    wire:model.defer="primaryStoreId"
                                    id="primaryStoreId"
                                    name="primaryStoreId"
                                    class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-arm-blue-500 focus:outline-none focus:ring-arm-blue-500 sm:text-sm"
                                >
                                    <option value="">{{ __('Choose a primary store...') }}</option>
                                    @foreach($stores->whereIn('id', $assignedStores) as $store)
                                        <option value="{{ $store->id }}">{{ $store->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                    </div>
                @endif

                {{-- Department Selection --}}
                <div class="col-span-3">
                    <x-input-label for="department" :value="__('Select a Department')" />

                    <select
                        wire:model.defer="department"
                        name="department"
                        id="department"
                        class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-arm-blue-500 focus:outline-none focus:ring-arm-blue-500 sm:text-sm"
                    >
                        <option value="">{{ __('Choose a department...') }}</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}">
                                {{ $dept->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Role Assignment --}}
                <div class="col-span-3">
                    <x-input-label for="role" :value="__('Select Role')" />

                    <div class="columns-2">
                        @foreach($allRoles as $role)
                            <div class="relative flex items-start">
                                <div class="flex h-6 items-center">
                                    <input
                                        wire:model="assignedRole"
                                        value="{{ $role->name }}"
                                        id="role-{{ $role->id }}"
                                        aria-describedby="role-{{ $role->id }}-description"
                                        name="assignedRole"
                                        type="radio"
                                        class="h-4 w-4 border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                                    >
                                </div>
                                <div class="ml-3 text-sm leading-6">
                                    <label for="role-{{ $role->id }}" class="text-gray-900">
                                        {{ $role->name }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Qualified Individual Assignment --}}
            @can('create-stores')
                <div class="relative flex items-start border-y py-5 mt-5">
                    <div class="flex h-6 items-center">
                        <input
                            wire:model.defer="qi"
                            id="qi"
                            name="qi"
                            type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                        >
                    </div>
                    <div class="ml-3 text-sm leading-6">
                        <label for="qi" class="font-medium text-gray-900">
                            {{ __('Qualified Individual') }}
                        </label>
                    </div>
                </div>
            @endcan

            {{-- Remediation Reminders --}}
            @if($user->can('create-users') && $remediationRemindersActive)
                <div>
                    <x-input-label :value="__('Remediation Reminders')" class="mt-5" />

                    <ul class="max-w-sm flex flex-col mt-1">
                        @foreach(\App\Enums\AuditTypes::cases() as $type)
                            <li class="inline-flex items-center gap-x-2 py-3 px-4 text-sm font-medium bg-white border border-gray-200 text-gray-800 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg">
                                <div class="relative flex items-start w-full">
                                    <div class="flex items-center h-5">
                                        <input
                                            id="audit-type-{{ $type->value }}"
                                            wire:model="selectedAuditTypes"
                                            value="{{ $type->value }}"
                                            name="selectedAuditTypes[]"
                                            type="checkbox"
                                            class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                                        >
                                    </div>
                                    <label for="audit-type-{{ $type->value }}" class="ms-3.5 block w-full text-sm text-gray-600">
                                        {{ $type->label() }}
                                    </label>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <div class="mt-6 flex gap-x-3">
            <button
                type="submit"
                class="inline-flex items-center justify-center rounded-md border border-transparent bg-arm-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-arm-blue-700 focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2 sm:w-auto"
            >
                {{ __('Save Changes') }}
            </button>

            <button
                type="button"
                wire:click="$emit('slide-over.close')"
                class="inline-flex items-center justify-center rounded-md border border-arm-blue-600 px-4 py-2 text-sm font-medium text-arm-blue-600 shadow-sm focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2 sm:w-auto"
            >
                {{ __('Cancel') }}
            </button>
        </div>
    </div>
</x-wire-elements-pro::tailwind.slide-over>
