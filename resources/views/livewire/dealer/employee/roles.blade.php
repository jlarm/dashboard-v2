<div>
    @foreach($roles as $role)
        <div class="relative flex items-start">
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
