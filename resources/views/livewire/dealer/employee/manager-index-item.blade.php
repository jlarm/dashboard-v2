<tr>
    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8">
        {{ $user->name }}
    </td>
    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
        <div><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></div>
        <div>{{ $user->phoneNumber }}</div>
    </td>
    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
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
    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
        @if(!$totalCourses)
            {{ __('-') }}
        @else
            {{ $completed }} of {{ $totalCourses }} passed
        @endif
    </td>
    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 flex justify-end text-sm font-medium sm:pr-6 lg:pr-8">
        {{--        <a href="{{ route('dealer.employees.show', $user) }}" class="text-sm">View</a>--}}
    </td>
</tr>

