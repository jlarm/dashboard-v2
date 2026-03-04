<x-table.row>
    <x-table.cell>{{ Str::limit($course->name, 40) }}</x-table.cell>
    <x-table.cell>{{ $course->lastResult ? $course->lastResult->created_at->format('F d, Y') : 'Never' }}</x-table.cell>
    <x-table.cell>
        <span
            @class([
                'inline-flex items-center gap-x-1.5 py-0.5 px-1.5 rounded-md text-xs font-medium',
                'text-teal-800 bg-teal-100' => $this->status() === 'passed',
                'text-red-700 bg-red-100' => $this->status() === 'failed',
                'text-yellow-700 bg-yellow-100' => $this->status() === 'expired',
                'bg-gray-100 text-gray-600' => !$course->lastResult || $this->status() === null,
            ])
            >
                {{ $this->status() === 'expired' ? 'Retake Required' : Str::title($this->status() ?? 'Not Taken') }}
        </span>
    </x-table.cell>
    <x-table.cell class="flex justify-end">
        @can('create-dealerships')
            @if(!$course->lastResult)
                <span
                    onclick="Livewire.emit('modal.open', 'tenant.employee.components.edit-course-taken-modal', @js(['course' => $course->id, 'user' => $user->id]))"
                    class="text-arm-blue-600 hover:text-arm-blue-900 hover:cursor-pointer">
                    Edit
                </span>
            @endif
        @endcan
    </x-table.cell>
</x-table.row>
