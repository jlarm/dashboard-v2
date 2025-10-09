<x-table.row>
    <x-table.cell>{{ Str::headline($user->name) }}</x-table.cell>
    <x-table.cell>{{ Str::lower($user->email) }}</x-table.cell>
    <x-table.cell>
        @if($user->roles->isEmpty())
            <span class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-800 ring-1 ring-inset ring-red-600/20">!! No Role Assigned !!</span>
        @else
            @foreach($user->roles as $role)
                @if($role->name === 'Manager')
                    <span
                        class="inline-flex items-center rounded-md bg-indigo-50 px-2 py-1 text-xs font-medium text-indigo-700 ring-1 ring-inset ring-indigo-700/10">{{ $role->name }}</span>
                @elseif($role->name === 'Employee')
                    <span
                        class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">{{ $role->name }}</span>
                @elseif($role->name === 'Consultant')
                    <span
                        class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">{{ $role->name }}</span>
                @else
                    <span
                        class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">{{ $role->name }}</span>
                @endif
            @endforeach
        @endif
    </x-table.cell>
    @if(tenant('locations'))
        <x-table.cell>
            @foreach($user->stores as $store)
                <div class="flex flex-col">
                    <span>{{ $store->name }}</span>
                </div>
            @endforeach
        </x-table.cell>
    @endif
    <x-table.cell>{{ $user->department->name ?? '-' }}</x-table.cell>
    <x-table.cell>
        @if($user->total_completed_courses === $user->total_user_courses)
            <span
                class="inline-flex items-center rounded-md bg-green-100 px-2 py-1 text-xs font-medium text-green-700">Completed</span>
        @else
            {{ $user->total_completed_courses }} of {{ $user->total_user_courses }}
        @endif
    </x-table.cell>
    <x-table.cell>
        @if(auth()->user()->id !== $user->id && !$user->hasRole('Consultant'))
            <a href="{{ route('dealer.stores.employees.show', [$store, $user]) }}" class="text-sm">View</a>
        @endif
    </x-table.cell>
</x-table.row>
