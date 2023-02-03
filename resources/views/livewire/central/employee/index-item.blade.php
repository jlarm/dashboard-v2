<tr>
    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ $user->name }}</td>
    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $user->email }}</td>
    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $user->phoneNumber }}</td>
    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
        @if( $user->roles->first()->name == 'super-admin')
            <span
                class="inline-flex items-center rounded bg-indigo-100 px-2 py-0.5 text-xs font-medium text-indigo-800">{{  $user->roles->first()->name }}</span>
        @elseif( $user->roles->first()->name == 'Admin')
            <span
                class="inline-flex items-center rounded bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-800">{{  $user->roles->first()->name }}</span>
        @elseif( $user->roles->first()->name == 'Consultant')
            <span
                class="inline-flex items-center rounded bg-red-100 px-2 py-0.5 text-xs font-medium text-red-800">{{  $user->roles->first()->name }}</span>
        @else
            <span
                class="inline-flex items-center rounded bg-green-100 px-2 py-0.5 text-xs font-medium text-green-800">{{  $user->roles->first()->name }}</span>
        @endif
    </td>
    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6 space-x-5">
        <a href="{{ route('employees.view', $user) }}" class="text-arm-blue-600 hover:text-arm-blue-900">View<span
                class="sr-only">, {{ $user->name }}</span></a>
    </td>
</tr>
