<x-table.row>
    <x-table.cell>{{ $user->name }}</x-table.cell>
    <x-table.cell>{{ $user->email }}</x-table.cell>
    <x-table.cell>{{ $user->phoneNumber }}</x-table.cell>
    <x-table.cell>{{ $completed }} of {{ $totalCourses }} passed</x-table.cell>
    <x-table.cell>
        @if( $user->roles->first()->name == 'super-admin')
            <span
                class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">{{  $user->roles->first()->name }}</span>
        @elseif( $user->roles->first()->name == 'Admin')
            <span
                class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">{{  $user->roles->first()->name }}</span>
        @elseif( $user->roles->first()->name == 'Consultant')
            <span
                class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">{{  $user->roles->first()->name }}</span>
        @else
            <span
                class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">{{  $user->roles->first()->name }}</span>
        @endif
    </x-table.cell>
    <x-table.cell>
        <a href="{{ route('employees.view', $user->slug) }}">View</a>
    </x-table.cell>
</x-table.row>
