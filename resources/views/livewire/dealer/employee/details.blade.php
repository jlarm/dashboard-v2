<div class="flex gap-3">
    @if(auth()->user()->id != $user->id)
        <button onclick="Livewire.emit('slide-over.open', 'dealer.employee.edit', @js(['user' => $user->id]))" class="w-full rounded bg-arm-blue-600 px-2 py-1 text-sm font-semibold text-white shadow-sm hover:bg-arm-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-arm-blue-600">Edit</button>
        @can('create-stores')
        <button onclick="Livewire.emit('modal.open', 'dealer.employee.delete', @js(['user' => $user->id]))" class="w-full rounded bg-red-600 px-2 py-1 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">Delete</button>
        @endcan
    @endif
</div>