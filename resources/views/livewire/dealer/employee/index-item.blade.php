<tr>
    <td class="px-4 py-4">
        <div class="flex space-x-4 w-max">
            <div class="flex-1">
                <span class="text-sm font-semibold text-gray-800">{{ $user->name }}</span>
            </div>
        </div>
    </td>
    <td class="text-sm text-gray-700">
        <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
    </td>
    <td class="text-sm text-gray-700">
        {{ $user->phone }}
    </td>
    <td class="px-4 py-4">
        @foreach($user->roles as $role)
            @if($role->name == 'Manager')
                <span class="inline-flex items-center rounded bg-indigo-100 px-2 py-0.5 text-xs font-medium text-indigo-800">{{ $role->name }}</span>
            @elseif($role->name == 'Employee')
                <span class="inline-flex items-center rounded bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-800">{{ $role->name }}</span>
            @elseif($role->name == 'Consultant')
                <span class="inline-flex items-center rounded bg-red-100 px-2 py-0.5 text-xs font-medium text-red-800">{{ $role->name }}</span>
            @else
                <span class="inline-flex items-center rounded bg-green-100 px-2 py-0.5 text-xs font-medium text-green-800">{{ $role->name }}</span>
            @endif
        @endforeach
    </td>
    <td class="text-sm text-gray-700">
        {{ $user->store->name ?? 'null' }}
    </td>
    <td class="px-4 py-4 text-right">
{{--        <a class="text-arm-blue-600" href="{{ route('tenant.employee.show', $user) }}">View</a>--}}
    </td>
</tr>
