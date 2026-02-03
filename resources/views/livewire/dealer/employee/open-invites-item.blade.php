<x-table.row>
    <x-table.cell>
        <input wire:model="parent.selected" value="{{ $invite->id }}" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600">
    </x-table.cell>
    <x-table.cell class="pl-4 pr-3">{{ $invite->name }}</x-table.cell>
    <x-table.cell>{{ $invite->email }}</x-table.cell>
    <x-table.cell>{{ $invite->created_at->format('F d, Y') }}</x-table.cell>
    <x-table.cell>{{ $invite->user->name }}</x-table.cell>
    <x-table.cell class="flex justify-end gap-3">
        <div class="relative">
            <svg wire:loading class="absolute top-1 -left-3 animate-spin -ml-1 mr-3 h-3 w-3 text-arm-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <button wire:click="sendInvite">Resend Invite</button>
        </div>
        <button
            class="text-red-500"
            wire:click="$emit('modal.open', 'dealer.employee.delete-invite', @js(['inviteId' => $invite->id]))"
        >
            Delete
        </button>
    </x-table.cell>
</x-table.row>
