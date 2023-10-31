<tr class="odd:bg-gray-50 hover:bg-arm-blue-50">
    {{--    @can('delete-stores')--}}
    {{--        <td class="relative px-7 sm:w-12 sm:px-6">--}}
    {{--            <input--}}
    {{--                type="checkbox"--}}
    {{--                class="absolute left-4 top-1/2 -mt-2 h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"--}}
    {{--                value="{{ $user->id }}"--}}
    {{--            >--}}
    {{--        </td>--}}
    {{--    @endcan--}}
    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8">
        {{ Str::headline($user->name) }}
    </td>
    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
        <div><a href="mailto:{{ $user->email }}">{{ Str::lower($user->email) }}</a></div>
    </td>
    @if(tenant('locations'))
        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
            @foreach($user->stores as $store)
                <div class="flex flex-col">
                    <span>{{ $store->name }}</span>
                </div>
            @endforeach
        </td>
    @endif
    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
        {{ $user->department->name ?? '' }}
    </td>
    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
        @foreach($user->roles as $role)
            @if($role->name == 'Manager')
                <span
                    class="inline-flex items-center rounded-md bg-arm-blue-50 px-2 py-1 text-xs font-medium text-arm-blue-700 ring-1 ring-inset ring-arm-blue-700/10">{{ $role->name }}</span>
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
    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
        @if($user->total_completed_courses === $user->total_user_courses)
            <span
                class="inline-flex items-center rounded-md bg-green-100 px-2 py-1 text-xs font-medium text-green-700">Completed</span>
        @else
            {{ $user->total_completed_courses }} of {{ $user->total_user_courses }}
        @endif
    </td>
    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 flex justify-end text-sm font-medium sm:pr-6 lg:pr-8">
        @if(!$user->hasRole('Consultant'))
            <a href="{{ route('dealer.employees.show', $user) }}"
               class="text-sm text-arm-blue-500 hover:text-arm-blue-700">View</a>
        @endif
    </td>
</tr>
