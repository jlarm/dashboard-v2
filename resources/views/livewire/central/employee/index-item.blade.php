<x-table.row>
    @php($roleName = $user->roles->first()?->name ?? 'unassigned')
    <x-table.cell>{{ $user->name }}</x-table.cell>
    <x-table.cell>{{ $user->email }}</x-table.cell>
    <x-table.cell>{{ $completed }} of {{ $totalCourses }} passed</x-table.cell>
    <x-table.cell>
        @if($roleName === 'super-admin')
            <span
                class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">{{ $roleName }}</span>
        @elseif($roleName === 'Admin')
            <span
                class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">{{ $roleName }}</span>
        @elseif($roleName === 'Consultant')
            <span
                class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">{{ $roleName }}</span>
        @else
            <span
                class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">{{ $roleName }}</span>
        @endif
    </x-table.cell>
    <x-table.cell>
        @if(filled($user->slug))
            <a href="{{ route('employees.view', $user->slug) }}">View</a>
        @else
            <span class="text-gray-400">-</span>
        @endif
    </x-table.cell>
</x-table.row>
