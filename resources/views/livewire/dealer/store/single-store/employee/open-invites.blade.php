<div class="px-6">

    <div
        class="py-5 sm:flex sm:items-center sm:justify-between">
        <div class="min-w-0 flex-1">
            <h1 class="text-4xl font-bold text-arm-blue-900 sm:truncate">Open Invites</h1>
        </div>
        <a
            class="inline-flex items-center px-4 py-2 bg-arm-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-arm-blue-700 focus:bg-arm-blue-700 active:bg-arm-blue-900 focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
            href="{{ route('dealer.stores.employees', $store) }}"
        >
            Back to Employees
        </a>
    </div>
    <div class="border rounded-md">
        <div class="p-6">
            <div>
                <div class="md:w-1/3 px-3 sm:px-0 mb-5">
                    <div>
                        <label for="search" class="sr-only">Search</label>
                        <input type="search" name="search" id="search"
                               wire:model="search"
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"
                               placeholder="Search by Name...">
                    </div>
                </div>
                <div>
                    <div class="inline-block min-w-full py-2 align-middle">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead>
                            <tr>
                                <th scope="col"
                                    class="whitespace-nowrap py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                                    Name
                                </th>
                                <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">Email</th>
                                <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">Invite
                                    Sent
                                </th>
                                <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">Sent
                                    By
                                </th>
                                <th scope="col" class="relative whitespace-nowrap py-3.5 pl-3 pr-4 sm:pr-0">
                                    <span class="sr-only">Edit</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse($invites as $invite)
                                <tr>
                                    <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm text-gray-500 sm:pl-0">
                                        {{ $invite->name }}
                                    </td>
                                    <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-900">
                                        {{ $invite->email }}
                                    </td>
                                    <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-900">
                                        {{ $invite->created_at->format('F d, Y') }}
                                    </td>
                                    <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-900">
                                        {{ $invite->user->name }}
                                    </td>
                                    <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-900">
                                        @if($invite->user_id === auth()->id())
                                            {{--                                        <button class="text-gray-500"--}}
                                            {{--                                                wire:click="$emit('modal.open', 'dealer.employee.resend-invite',  @js(['invite' => $invite->id]))">--}}
                                            {{--                                            Resend--}}
                                            {{--                                        </button>--}}
                                            <button
                                                class="text-red-500"
                                                wire:click="$emit('modal.open', 'dealer.employee.delete-invite',  @js(['invite' => $invite->id]))"
                                            >
                                                Delete
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7"
                                        class="px-4 py-4 text-center text-xl text-arm-blue-500 font-medium sm:pr-6 space-x-3">
                                        No Open Invites
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="mt-10">
                {{ $invites->links() }}
            </div>
        </div>
    </div>

=======
<div>
    <livewire:dealer.store.single-store-sub-nav :store="$store"/>
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="mt-8 flow-root">
            <div class="md:w-1/3 px-3 sm:px-0 mb-5">
                <div>
                    <label for="search" class="sr-only">Search</label>
                    <input type="search" name="search" id="search"
                           wire:model="search"
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"
                           placeholder="Search by Name...">
                </div>
            </div>
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead>
                        <tr>
                            <th scope="col"
                                class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 lg:pl-8">
                                Name
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Email</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Invite
                                Sent
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Sent
                                By
                            </th>
                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6 lg:pr-8">
                                <span class="sr-only">Edit</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse($invites as $invite)
                            <tr>
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8">
                                    {{ $invite->name }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    {{ $invite->email }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    {{ $invite->created_at->format('F d, Y') }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    {{ $invite->user->name }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    @if($invite->user_id === auth()->id())
                                        <button
                                            class="text-red-500"
                                            wire:click="$emit('modal.open', 'dealer.employee.delete-invite',  @js(['invite' => $invite->id]))"
                                        >
                                            Delete
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7"
                                    class="px-4 py-4 text-center text-xl text-arm-blue-500 font-medium sm:pr-6 space-x-3">
                                    No Open Invites
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="mt-10">
            {{ $invites->links() }}
        </div>
    </div>
</div>
