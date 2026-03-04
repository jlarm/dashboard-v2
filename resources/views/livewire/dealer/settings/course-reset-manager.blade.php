<div class="space-y-5">
    <div class="max-w-3xl">
        <h2 class="text-base font-semibold text-gray-900">Reset Courses</h2>
        <p class="mt-1 text-sm text-gray-500">
            @if($isStoreScoped)
                Manage course progress resets for employees in {{ $storeName }}. You can choose to reset everyone in this store or target specific individuals.
            @else
                Manage course progress resets. You can choose to reset progress for everyone or target specific individuals.
            @endif
        </p>
    </div>

    <div class="inline-flex h-10 rounded-lg bg-gray-800/5 p-1">
        <button
            type="button"
            wire:click="setMode('everyone')"
            @class([
                'rounded-md px-6 text-sm font-medium transition-colors',
                'bg-white text-gray-700 shadow-sm' => $mode === 'everyone',
                'text-gray-500 hover:text-gray-700' => $mode !== 'everyone',
            ])
        >
            Everyone
        </button>
        <button
            type="button"
            wire:click="setMode('selected-users')"
            @class([
                'rounded-md px-6 text-sm font-medium transition-colors',
                'bg-white text-gray-700 shadow-sm' => $mode === 'selected-users',
                'text-gray-500 hover:text-gray-700' => $mode !== 'selected-users',
            ])
        >
            Select Users
        </button>
    </div>

    <div class="overflow-hidden rounded-lg border border-gray-200 bg-white">
        @if($mode === 'everyone')
            <div class="px-5 py-6">
                <p class="text-sm leading-6 text-gray-600">
                    This action will reset course progress for
                    <span class="font-semibold text-gray-900">all {{ $resettableUserCount }} employees</span>
                    @if($isStoreScoped)
                        in {{ $storeName }}.
                    @else
                        across all locations.
                    @endif
                </p>
            </div>
        @else
            <div class="border-b border-gray-200 px-5 py-4">
                <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                    <div class="relative flex-1">
                        <svg class="pointer-events-none absolute left-3 top-1/2 size-4 -translate-y-1/2 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m0 0A7.5 7.5 0 1 0 5.4 5.4a7.5 7.5 0 0 0 11.25 11.25Z" />
                        </svg>
                        <input
                            type="search"
                            wire:model.debounce.300ms="search"
                            class="block w-full rounded-md border-gray-300 py-2 pl-10 pr-3 text-sm text-gray-900 placeholder:text-gray-400 focus:border-arm-blue-500 focus:ring-arm-blue-500"
                            placeholder="{{ $isStoreScoped ? 'Search by name or email...' : 'Search by name, email or store...' }}"
                        >
                    </div>

                    <div class="inline-flex items-center rounded-md bg-gray-100 px-3 py-2 text-sm font-medium text-gray-600">
                        {{ $selectedUserCount }} selected
                    </div>
                </div>

                @error('selectedUserIds')
                    <p class="mt-3 text-sm font-medium text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="max-h-[420px] overflow-y-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="sticky top-0 bg-gray-50">
                    <tr>
                        <th scope="col" class="w-14 px-4 py-3 text-left">
                            <input
                                type="checkbox"
                                wire:model="selectAllVisible"
                                class="h-4 w-4 rounded border-gray-300 text-arm-green-600 focus:ring-arm-green-500"
                            >
                        </th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">User</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            {{ $isStoreScoped ? 'Department' : 'Store(s)' }}
                        </th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Status</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($users as $user)
                        @php
                            $statusLabel = 'Not Started';
                            $statusClasses = 'bg-gray-100 text-gray-600';
                            $isSelected = in_array($user->id, $selectedUserIds, true);

                            if ($user->total_user_courses > 0 && $user->total_completed_courses === $user->total_user_courses) {
                                $statusLabel = 'Completed';
                                $statusClasses = 'bg-green-100 text-green-700';
                            } elseif ($user->results_count > 0) {
                                $statusLabel = 'In Progress';
                                $statusClasses = 'bg-amber-100 text-amber-700';
                            }
                        @endphp
                        <tr
                            wire:key="course-reset-user-{{ $user->id }}"
                            wire:click="toggleSelectedUser({{ $user->id }})"
                            @class([
                                'cursor-pointer transition-colors',
                                'bg-arm-blue-50/50' => $isSelected,
                                'hover:bg-gray-50' => ! $isSelected,
                            ])
                        >
                            <td class="px-4 py-3 align-top">
                                <input
                                    type="checkbox"
                                    wire:model="selectedUserIds"
                                    wire:click.stop
                                    value="{{ $user->id }}"
                                    class="h-4 w-4 rounded border-gray-300 text-arm-green-600 focus:ring-arm-green-500"
                                >
                            </td>
                            <td class="px-4 py-3 align-top">
                                <div class="min-w-0">
                                    <p class="truncate text-sm font-medium text-gray-900">{{ Str::title($user->name) }}</p>
                                    <p class="truncate text-sm text-gray-500">{{ Str::lower($user->email) }}</p>
                                </div>
                            </td>
                            <td class="px-4 py-3 align-top text-sm text-gray-600">
                                @if($isStoreScoped)
                                    {{ $user->department?->name ?: 'No department assigned' }}
                                @else
                                    {{ $user->stores->pluck('name')->join(', ') ?: 'No store assigned' }}
                                @endif
                            </td>
                            <td class="px-4 py-3 align-top">
                                <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium {{ $statusClasses }}">
                                    {{ $statusLabel }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-sm text-gray-500">
                                No users match your search.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <div class="flex flex-col gap-3 border-t border-gray-200 pt-4 md:flex-row md:items-center md:justify-between">
        <div class="flex items-start gap-2 text-sm text-amber-700">
            <svg class="mt-0.5 size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
            </svg>
            <p>
                <span class="font-semibold">Permanent action.</span>
                Resetting courses removes all progress data for the selected participants.
            </p>
        </div>

        <x-danger-button
            type="button"
            wire:click="resetCourses"
            wire:loading.attr="disabled"
            :disabled="$mode === 'selected-users' && $selectedUserCount === 0"
            class="justify-center disabled:opacity-50"
        >
            {{ $mode === 'selected-users' ? 'Reset Selected Courses' : 'Reset All Courses' }}
        </x-danger-button>
    </div>
</div>
