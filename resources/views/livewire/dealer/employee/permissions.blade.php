<div>
    @foreach($permissions as $permission)
        <div class="relative flex items-start">
            <div class="flex h-6 items-center">
                <input
                    wire:model="assignedPermissions"
                    {{ in_array($permission->name, $assignedPermissions) ? 'checked' : '' }}
                    value="{{ $permission->name }}"
                    id="{{ $permission->name }}"
                    aria-describedby="{{ $permission->name }}"
                    name="{{ $permission->name }}"
                    type="checkbox"
                    class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"/>
            </div>
            <div class="ml-3 text-sm leading-6">
                <label for="{{ $permission->name }}" class="text-gray-900">{{ $permission->name }}</label>
            </div>
        </div>
    @endforeach
</div>
