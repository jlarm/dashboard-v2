<tr class="even:bg-gray-50">
    @php
        $hasQualifiedIndividualRole = $user->roles->contains('name', 'Qualified Individual');
        $displayRoles = $user->roles
            ->reject(fn ($role): bool => $role->name === 'Qualified Individual')
            ->values();
    @endphp
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
        <div class="flex items-center gap-2">
            <span>{{ Str::headline($user->name) }}</span>
            @if($hasQualifiedIndividualRole)
                <x-tooltip content="Qualified Individual" placement="top">
                    <span
                        data-qi-indicator
                        aria-label="Qualified Individual"
                        class="inline-flex h-5 w-5 flex-shrink-0 items-center justify-center text-green-700"
                    >
                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" color="currentColor" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" aria-hidden="true">
                            <path d="M11.3598 2.53349L9 4.5L5.5 4.5C4.94772 4.5 4.5 4.94772 4.5 5.5L4.5 9L2.53349 11.3598C2.22445 11.7307 2.22445 12.2693 2.53349 12.6402L4.5 15L4.5 18.5C4.5 19.0523 4.94772 19.5 5.5 19.5L9 19.5L11.3598 21.4665C11.7307 21.7756 12.2693 21.7756 12.6402 21.4665L15 19.5H18.5C19.0523 19.5 19.5 19.0523 19.5 18.5L19.5 15L21.4665 12.6402C21.7756 12.2693 21.7756 11.7307 21.4665 11.3598L19.5 9L19.5 5.5C19.5 4.94772 19.0523 4.5 18.5 4.5L15 4.5L12.6402 2.53349C12.2693 2.22445 11.7307 2.22445 11.3598 2.53349Z" />
                            <path d="M9 13L11 15L15.5 9.5" />
                        </svg>
                    </span>
                </x-tooltip>
            @endif
        </div>
    </td>
    <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-900">
        <div><a href="mailto:{{ $user->email }}">{{ Str::lower($user->email) }}</a></div>
    </td>
    @if(app('multipleStoresExist'))
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
        @if($user->roles->isEmpty())
            <span class="text-sm text-gray-400">-</span>
        @elseif($displayRoles->isEmpty())
            <span class="text-sm text-gray-400">-</span>
        @else
        @foreach($displayRoles as $role)
            @if($role->name === 'Manager')
                <span
                    data-role-badge="{{ Str::slug($role->name) }}"
                    class="inline-flex items-center rounded-md bg-arm-blue-50 px-2 py-1 text-xs font-medium text-arm-blue-700 ring-1 ring-inset ring-arm-blue-700/10">{{ $role->name }}</span>
            @elseif($role->name === 'Employee')
                <span
                    data-role-badge="{{ Str::slug($role->name) }}"
                    class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">{{ $role->name }}</span>
            @elseif($role->name === 'Consultant')
                <span
                    data-role-badge="{{ Str::slug($role->name) }}"
                    class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">{{ $role->name }}</span>
            @else
                <span
                    data-role-badge="{{ Str::slug($role->name) }}"
                    class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">{{ $role->name }}</span>
            @endif
        @endforeach
        @endif
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
