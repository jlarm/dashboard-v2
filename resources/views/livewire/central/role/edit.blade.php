<div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
    <div class="col-span-4 bg-white rounded-md p-4 flex flex-col space-y-5">
        <form wire:submit.prevent="updateRole">
            <div>
                <x-input-label for="name" :value="__('Update Role Name')"/>
                <x-text-input
                    wire:model.defer="name"
                    id="name"
                    class="block my-1 w-full"
                    type="text"
                    name="name"
                    :value="old('name')"
                    required
                    autofocus
                />
            </div>
            <x-primary-button>Update</x-primary-button>
        </form>
    </div>
    <div class="col-span-4 bg-white rounded-md p-4 flex flex-col space-y-5">
        <div class="flex flex-col space-y-1.5">
            <h3 class="text-lg font-semibold leading-none tracking-tight">Permissions</h3>
            <p class="text-sm text-neutral-500">Make changes to permissions here. Click update when
                you're done.</p>
        </div>
        <form wire:submit.prevent="updatePermissions" class="space-y-5">
            <div class="columns-4">
                @foreach($permissions as $permission)
                    <div class="relative flex items-start">
                        <div class="flex h-6 items-center">
                            <input
                                wire:model.defer="assignedPermissions"
                                {{ in_array($permission->name, $assignedPermissions) ? 'checked' : '' }}
                                value="{{ $permission->name }}"
                                id="{{ $permission->name }}"
                                aria-describedby="{{ $permission->name }}"
                                name="{{ $permission->name }}"
                                type="checkbox"
                                class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"/>
                        </div>
                        <div class="ml-3 text-sm leading-6">
                            <label for="{{ $permission->name }}"
                                   class="text-gray-900">{{ $permission->name }}</label>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="flex">
                <x-primary-button>Update</x-primary-button>
            </div>
        </form>
    </div>
    <div class="col-span-4 bg-white rounded-md p-4 flex flex-col space-y-5">
        <div class="flex flex-col space-y-1.5">
            <h3 class="text-lg font-semibold leading-none tracking-tight">Courses</h3>
            <p class="text-sm text-neutral-500">Assign courses this department should belong
                to.</p>
        </div>
        <form wire:submit.prevent="updateCourses" class="space-y-5">
            <div class="columns-2 space-y-5">
                @foreach($courses as $course)
                    <div
                        x-data="{ switchOn: {{ in_array($course->id, $assignedCourses) ? 'true' : 'false' }} }"
                        class="flex items-center space-x-2">
                        <input
                            id="{{ $course->id }}"
                            wire:model="assignedCourses"
                            {{ in_array($course->id, $assignedCourses) ? 'checked' : '' }}
                            value="{{ $course->id }}"
                            type="checkbox"
                            class="hidden"
                            :checked="switchOn"
                        >

                        <button
                            x-ref="switchButton"
                            checked="checked"
                            type="button"
                            @click="switchOn = ! switchOn"
                            :class="switchOn ? 'bg-arm-blue-600' : 'bg-neutral-200'"
                            class="relative inline-flex h-6 py-0.5 ml-4 focus:outline-none rounded-full w-10"
                            x-cloak>
                                        <span :class="switchOn ? 'translate-x-[18px]' : 'translate-x-0.5'"
                                              class="w-5 h-5 duration-200 ease-in-out bg-white rounded-full shadow-md"></span>
                        </button>

                        <label @click="$refs.switchButton.click(); $refs.switchButton.focus()"
                               :id="$id('switch')"
                               :class="{ 'text-arm-blue-600': switchOn, 'text-gray-400': ! switchOn }"
                               class="text-sm select-none truncate w-2/3"
                               for="{{ $course->id }}"
                               x-cloak>
                            {{ $course->name }}
                        </label>
                    </div>
                @endforeach
            </div>
            <x-primary-button>Update</x-primary-button>
        </form>
    </div>
    @if($role->name != 'Admin' && $role->name != 'Consultant')
        <div class="w-full col-span-4 flex justify-end">
            <button
                class="text-red-500"
                wire:click="$emit('modal.open', 'central.role.delete',  @js(['role' => $role->id]))"
            >
                Delete
            </button>
        </div>
    @endif
</div>
