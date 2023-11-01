<tr>
    <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-900">{{ $user->name }}</td>
    <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-900">{{ $user->email }}</td>
    <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-900">{{ $user->phoneNumber }}</td>
    <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-900">{{ $completed }} of {{ $totalCourses }} passed</td>
    <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-900">
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
    </td>
    <td class="relative whitespace-nowrap py-2 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
        <a href="{{ route('employees.view', $user) }}" class="text-arm-blue-600 hover:text-arm-blue-900">View<span
                class="sr-only">, {{ $user->name }}</span></a>
    </td>
</tr>
