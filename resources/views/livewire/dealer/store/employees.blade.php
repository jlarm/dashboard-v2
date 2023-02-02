<div class="w-full bg-white rounded-md shadow-sm shadow-gray-300">
    <div class="overflow-x-auto">
        <div class="inline-block min-w-full overflow-hidden align-middle">
            <table class="min-w-full">
                <thead
                    class="text-xs font-semibold tracking-widest text-gray-600 uppercase border-t border-b border-gray-100 bg-gray-50">
                <tr>
                    <td class="px-4 py-4">Name</td>
                    <td class="px-4 py-4">Email</td>
                    <td class="px-4 py-4">Phone</td>
                    <td class="px-4 py-4">Role</td>
                    <td class="px-4 py-4">Department</td>
                    <td class="px-4 py-4">&nbsp;</td>
                </tr>
                </thead>
                <tbody class="text-gray-700 whitespace-nowrap">
                @forelse($users as $user)
                    <tr>
                        <td class="px-4 py-4">
                            <div class="flex space-x-4 w-max">
                                <div class="flex-1">
                                    <span class="text-sm font-semibold text-gray-800">{{ $user->name }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-700">
                            <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-700">
                            {{ $user->phone }}
                        </td>
                        <td class="px-4 py-4">
                            @foreach($user->roles as $role)
                                @if($role->name == 'Manager')
                                    <span
                                        class="inline-flex items-center rounded bg-indigo-100 px-2 py-0.5 text-xs font-medium text-indigo-800">{{ $role->name }}</span>
                                @elseif($role->name == 'Employee')
                                    <span
                                        class="inline-flex items-center rounded bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-800">{{ $role->name }}</span>
                                @elseif($role->name == 'Consultant')
                                    <span
                                        class="inline-flex items-center rounded bg-red-100 px-2 py-0.5 text-xs font-medium text-red-800">{{ $role->name }}</span>
                                @else
                                    <span
                                        class="inline-flex items-center rounded bg-green-100 px-2 py-0.5 text-xs font-medium text-green-800">{{ $role->name }}</span>
                                @endif
                            @endforeach
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-700">
                            {{ $user->department->name ?? '' }}
                        </td>
                        <td class="px-4 py-4 text-right">
                            <a href="{{ route('dealer.employees.show', $user) }}">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-4 text-sm text-gray-700 text-center">
                            No employees found.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
