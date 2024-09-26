<tr class="even:bg-gray-50 hover:bg-arm-blue-50">
    <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm text-gray-500">
        {{ Str::headline($user->name) }}
    </td>
    <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-900">
        <div><a href="mailto:{{ $user->email }}">{{ Str::lower($user->email) }}</a></div>
    </td>
    <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-900">
        @foreach($user->roles as $role)
            @if($role->name == 'Manager')
                <span
                    class="inline-flex items-center rounded-md bg-indigo-50 px-2 py-1 text-xs font-medium text-indigo-700 ring-1 ring-inset ring-indigo-700/10">{{ $role->name }}</span>
            @elseif($role->name == 'Employee')
                <span
                    class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">{{ $role->name }}</span>
            @elseif($role->name == 'Consultant')
                <span
                    class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">{{ $role->name }}</span>
            @else
                <span
                    class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">{{ $role->name }}</span>
            @endif
        @endforeach
    </td>
    @if(tenant('locations'))
        <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-900">
            @foreach($user->stores as $store)
                <div class="flex flex-col">
                    <span>{{ $store->name }}</span>
                </div>
            @endforeach
        </td>
    @endif
    <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-900">
        {{ $user->department->name ?? '-' }}
    </td>
    <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-900">
        @if($user->total_completed_courses === $user->total_user_courses)
            <span
                class="inline-flex items-center rounded-md bg-green-100 px-2 py-1 text-xs font-medium text-green-700">Completed</span>
        @else
            {{ $user->total_completed_courses }} of {{ $user->total_user_courses }}
        @endif
    </td>
    <td class="relative whitespace-nowrap py-2 pl-3 pr-4 text-right text-sm font-medium">
        <a href="{{ route('dealer.stores.employees.show', [$store, $user]) }}" class="text-sm">View</a>
    </td>
</tr>
