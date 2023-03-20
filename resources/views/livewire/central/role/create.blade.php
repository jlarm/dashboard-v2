<form wire:submit.prevent="create" class="space-y-10">
    <div class="w-1/4">
        <x-input-label for="name" :value="__('Role Name')"/>
        <x-text-input
            wire:model="name"
            id="name"
            class="block mt-1 w-full"
            type="text"
            name="name"
            :value="old('name')"
            required
            autofocus
        />
    </div>
    <div class="space-y-3">
        <h2>Assign Permissions</h2>
        <div>
            @foreach($permissions as $permission)
                <div class="relative flex items-start">
                    <div class="flex h-6 items-center">
                        <input
                            wire:model.defer="assignedPermissions.{{ $permission->name }}"
                            value="{{ $permission->name }}"
                            id="{{ $permission->name }}"
                            aria-describedby="{{ $permission->name }}"
                            name="{{ $permission->name }}"
                            type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
                    </div>
                    <div class="ml-3 text-sm leading-6">
                        <label for="{{ $permission->name }}" class="text-gray-900">{{ $permission->name }}</label>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div>
        <x-primary-button>Submit</x-primary-button>
    </div>
</form>
