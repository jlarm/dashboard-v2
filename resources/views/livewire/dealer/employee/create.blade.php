<form wire:submit.prevent="submit" class="w-full max-w-4xl mx-auto space-y-10">
    @error('department') <p class="text-red-500">{{ $message }}</p> @enderror
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
    @can('create-stores')
        @if(tenant('locations'))
            <div class="col-span-3">
                <div class="col-span-3">
                    <x-input-label for="dealers" :value="__('Select a Store, Cmd/Ctrl click to select multiple')"/>
                    <select wire:model.defer="dealers"
                            class="w-full border-gray-300 focus:border-arm-blue-500 focus:ring-arm-blue-500 rounded-md shadow-sm"
                            multiple required>
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
                            class="@if($qualifiedCount > 0) hidden @endif relative flex items-start">
                            <div class="flex h-6 items-center">
                                <input
                                    wire:model.defer="roles"
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

        <div x-cloak="" x-show="open" class="space-y-3 grid grid-cols-1 gap-3">
            <p>Add the completion date of any courses completed in the past year.</p>
            @foreach($allCourses as $course)
                <div>
                    <p class="text-sm @if(array_key_exists($course->id, $courses)) text-green-500 font-bold @endif">{{ $course->name }}</p>
                    <div class="text-gray-400">
                        <x-text-input wire:model="courses.{{$course->id}}" id="courses.{{$course->id}}"
                                      class="w-full block mt-1"
                                      type="date" name="name"
                                      :value="old('name')"/>
                    </div>
                </div>
            @endforeach
        </div>

        <x-primary-button>Submit</x-primary-button>

    </div>

</form>
