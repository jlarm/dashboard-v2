<div class="flex gap-3">
    @if(auth()->user()->id !== $user->id)
        <x-armp.button wire:click="$emit('slide-over.open', 'dealer.employee.edit', { user: {{ $user->id }} })" variant="primary" size="sm">Edit</x-armp.button>
        @can('create-stores')
            <x-armp.button wire:click="$emit('modal.open', 'dealer.employee.delete', { user: {{ $user->id }} })" variant="danger" size="sm">Delete</x-armp.button>
        @endcan
        @role('super-admin')
            <x-armp.button href="{{ route('dealer.employee.impersonate', $user) }}" size="sm">Login as {{ Str::title($user->name) }}</x-armp.button>
        @endrole
    @endif
</div>
