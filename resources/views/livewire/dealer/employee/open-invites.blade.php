<div class="space-y-10">
    <div>
        <div class="w-full bg-white rounded-md shadow-sm shadow-gray-300">
            <div class="overflow-x-auto">
                <div class="inline-block min-w-full overflow-hidden align-middle">
                    <table class="min-w-full">
                        <thead class="text-xs font-semibold tracking-widest text-gray-600 uppercase border-t border-b border-gray-100 bg-gray-50">
                        <tr>
                            <td class="px-4 py-4">name</td>
                            <td class="px-4 py-4">Email Address</td>
                            <td class="px-4 py-4">Store</td>
                            <td class="px-4 py-4">Invite Sent</td>
                            <td class="px-4 py-4">Sent By</td>
                            <td class="px-4 py-4">&nbsp;</td>
                        </tr>
                        </thead>
                        <tbody class="text-gray-700 whitespace-nowrap">
                        @forelse($invites as $invite)
                            <tr>
                                <td class="px-4 py-4">
                                    <div class="flex space-x-4 w-max">
                                        <div class="flex-1">
                                            <span class="text-sm font-semibold text-gray-800">{{ $invite->name }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-sm text-gray-700">
                                    {{ $invite->email }}
                                </td>
                                <td class="text-sm text-gray-700">
                                    {{ $invite->store->name ?? '' }}
                                </td>
                                <td class="text-sm text-gray-700">
                                    {{ $invite->created_at->format('F d, Y') }}
                                </td>
                                <td class="px-4 py-4">
                                    {{ $invite->user->name }}
                                </td>
                                <td class="px-4 py-4 text-right text-sm font-medium sm:pr-6 space-x-3">
                                    @if($invite->user_id === auth()->id())
                                        <button class="text-gray-500" wire:click="$emit('modal.open', 'employee.resend-invite',  @js(['invite' => $invite->id]))">Resend</button>
                                        <button class="text-red-500" wire:click="$emit('modal.open', 'dealer.employee.delete-invite',  @js(['invite' => $invite->id]))">Delete</button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-4 text-center text-xl text-arm-blue-500 font-medium sm:pr-6 space-x-3">
                                    No open invites
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{ $invites->links() }}
</div>
