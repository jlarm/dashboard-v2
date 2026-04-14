<form wire:submit.prevent="submit" class="w-full max-w-4xl mx-auto space-y-10">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Employee Name')"/>
            <x-text-input wire:model.defer="name" id="name" class="block mt-1 w-full" type="text" name="name"
                          :value="old('name')" required/>
            @error('name') <p class="text-red-500">{{ $message }}</p> @enderror
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Employee Email Address')"/>
            <x-text-input wire:model.defer="email" id="email" class="block mt-1 w-full" type="email" name="email"
                          :value="old('email')" required/>
            @error('email') <p class="text-red-500">{{ $message }}</p> @enderror
        </div>
    </div>

    <!-- Store -->
    @if($stores->count() > 1)
        @php
            $selectedStoreIds = array_map('intval', $dealers);
            $selectedStores = $stores->whereIn('id', $selectedStoreIds)->values();
        @endphp
        <div
            class="col-span-3"
            x-data="{
                open: false,
                checkedCount: {{ count($dealers) }},
                updateCount() { this.checkedCount = this.$el.querySelectorAll('input[type=checkbox]:checked').length; }
            }"
        >
            <div class="relative" @change="updateCount()">
                <x-input-label for="dealers" :value="__('Select Store(s)')"/>
                <button
                    type="button"
                    x-on:click="open = !open"
                    class="mt-1 flex w-full items-center justify-between rounded-md border border-gray-300 bg-white px-3 py-2 text-left shadow-sm focus:border-arm-blue-500 focus:outline-none focus:ring-1 focus:ring-arm-blue-500"
                >
                    <span class="truncate text-sm text-gray-700">
                        @if($selectedStores->isNotEmpty())
                            {{ $selectedStores->pluck('name')->join(', ') }}
                        @else
                            Select one or more stores
                        @endif
                    </span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.167l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                    </svg>
                </button>
                <div
                    x-cloak
                    x-show="open"
                    x-transition.origin.top
                    x-on:click.outside="open = false"
                    class="absolute left-0 right-0 z-50 mt-2 rounded-md border border-gray-200 bg-white p-3 shadow-lg"
                >
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Choose Stores</p>
                    <div class="mt-2 max-h-56 space-y-2 overflow-y-auto pr-1">
                        @foreach($stores as $store)
                            <label class="flex items-center gap-2 rounded px-1 py-1 hover:bg-gray-50">
                                <input
                                    type="checkbox"
                                    wire:model="dealers"
                                    value="{{ $store->id }}"
                                    class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                                />
                                <span class="text-sm text-gray-700">{{ $store->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                @error('dealers') <p class="text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Primary Store --}}
            <div x-show="checkedCount > 1" x-cloak class="mt-4">
                <x-input-label for="primaryStoreId" :value="__('Primary Store')" />
                <select
                    wire:model.defer="primaryStoreId"
                    id="primaryStoreId"
                    name="primaryStoreId"
                    :required="checkedCount > 1"
                    class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-arm-blue-500 focus:outline-none focus:ring-arm-blue-500 sm:text-sm"
                >
                    <option value="">{{ __('Choose a primary store...') }}</option>
                    @foreach($stores->whereIn('id', $selectedStoreIds) as $primaryStore)
                        <option value="{{ $primaryStore->id }}">{{ $primaryStore->name }}</option>
                    @endforeach
                </select>
                @error('primaryStoreId') <p class="text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>
    @elseif($stores->count() === 1)
        <div class="col-span-3">
{{--            <x-input-label :value="__('Store')"/>--}}
{{--            <p class="mt-1 text-sm text-gray-600">This invite will be assigned to {{ $stores->first()->name }}.</p>--}}
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
        @error('department') <p class="text-red-500 mt-1">{{ $message }}</p> @enderror
    </div>

    <!-- Role -->
    <div class="col-span-3">
        <x-input-label for="role" :value="__('Select a Role')"/>
        <select
            required
            wire:model.defer="role"
            name="role"
            id="role"
            class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-arm-blue-500 focus:outline-none focus:ring-arm-blue-500 sm:text-sm"
        >
            <option value="">Select a role</option>
            @foreach($allRoles as $roleOption)
                <option value="{{ $roleOption->name }}">{{ $roleOption->name }}</option>
            @endforeach
        </select>
        @error('role') <p class="text-red-500 mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="relative flex items-start border-y py-5">
        <div class="flex h-6 items-center">
            <input wire:model.defer="qi" id="comments" aria-describedby="comments-description" name="comments" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
        </div>
        <div class="ml-3 text-sm leading-6">
            <label for="comments" class="font-medium text-gray-900">This employee will be a Qualified Individual</label>
        </div>
    </div>

    <div class="space-y-10" x-data="{ open: false }">
        <div class="relative flex gap-x-3 bg-gray-100 p-3 rounded">
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input
                        id="courses"
                        x-on:click="open = ! open"
                        type="checkbox"
                        class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="courses" class="font-medium text-gray-900">Add previously completed courses</label>
                </div>
            </div>
        </div>

        <div x-cloak x-show="open" class="space-y-3 grid grid-cols-1 gap-3">
            <p>Add completed courses that are still valid.</p>
            @foreach($allCourses as $course)
                <div>
                    <p class="text-sm">{{ $course->name }}</p>
                    <div class="text-gray-400">
                        <x-date-picker
                            wire:model.defer="courses.{{$course->id}}"
                            id="courses.{{$course->id}}"
                            name="courses.{{$course->id}}"
                            class="w-full block mt-1"
                        />
                    </div>
                </div>
            @endforeach
        </div>

        <x-primary-button>Submit</x-primary-button>

    </div>

</form>
