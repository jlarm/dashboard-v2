<div class="flex flex-col space-y-3">
    <span class="lowercase">{{ $user->email }}</span>
    <span>{{ $user->phone }}</span>
    <div class="flex flex-col">
        @foreach($user->stores as $store)
            <div>
                <span>{{ $store->name ?? '' }}</span>
            </div>
        @endforeach
        <span>{{ $user->department->name ?? '' }} {{ $user->roles->first()->name ?? '' }}</span>
    </div>
    @if(auth()->user()->id != $user->id)
        <button
            onclick="Livewire.emit('slide-over.open', 'dealer.employee.edit', @js(['user' => $user->id]))"
            class="sm:order-0 order-1 ml-3 rounded-md bg-arm-blue-500 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-arm-blue-600 focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2 sm:ml-0">

            Edit
        </button>
    @endif
</div>
