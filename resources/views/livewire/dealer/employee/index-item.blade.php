<tr class="even:bg-gray-50">
    <td class="whitespace-nowrap py-2 px-3 text-sm text-gray-500">
        <input
            type="checkbox"
            wire:click.prevent="$emitUp('toggleUserSelection', {{ $user->id }})"
            value="{{ $user->id }}"
            {{ in_array($user->id, $selectedUsers) ? 'checked' : '' }}
            class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600 cursor-pointer"
        />
    </td>
    <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm text-gray-500">
        {{ Str::headline($user->name) }}
    </td>
    <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-900">
        <div><a href="mailto:{{ $user->email }}">{{ Str::lower($user->email) }}</a></div>
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
        {{ $user->department->name ?? '' }}
    </td>
    <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-900">
        @foreach($user->roles as $role)
            @if($role->name === 'Manager')
                <span
                    class="inline-flex items-center rounded-md bg-arm-blue-50 px-2 py-1 text-xs font-medium text-arm-blue-700 ring-1 ring-inset ring-arm-blue-700/10">{{ $role->name }}</span>
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
    </td>
    <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-900">
        @if($user->total_completed_courses === $user->total_user_courses)
            <span
                class="inline-flex items-center rounded-md bg-green-100 px-2 py-1 text-xs font-medium text-green-700">Completed</span>
        @else
            {{ $user->total_completed_courses }} of {{ $user->total_user_courses }}
        @endif
    </td>
    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 flex justify-end text-sm font-medium sm:pr-6 lg:pr-8">
        @if(auth()->user()->id !== $user->id && !$user->hasRole('Consultant'))
            <a href="{{ route('dealer.employees.show', $user) }}"
               class="text-sm text-arm-blue-500 hover:text-arm-blue-700">View</a>
        @endif
    </td>
</tr>
