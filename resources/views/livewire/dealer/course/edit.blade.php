<div class="w-full p-10 shadow-lg">
    @foreach($departments as $department)
        <div class="relative flex items-start">
            <input
                wire:model="assignedRoles"
                {{ in_array($department->name, $assignedDepartments) ? 'checked' : '' }}
                value="{{ $department->name }}"
                id="{{ $department->name }}"
                aria-describedby="{{ $department->name }}"
                name="{{ $department->name }}"
                type="checkbox"
                class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
            />
            <div class="ml-3 text-sm leading-6">
                <label for="{{ $department->name }}" class="text-gray-900">{{ $department->name }}</label>
            </div>
        </div>
    @endforeach
</div>
