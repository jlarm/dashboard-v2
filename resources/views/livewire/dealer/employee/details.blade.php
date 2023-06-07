<div class="flex flex-col space-y-3">
    <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
    <span>{{ $user->phoneNumber }}</span>
    <div class="flex flex-col">
        @foreach($user->stores as $store)
            <div>
                <span>{{ $store->name ?? 'Liberty Auto Plaza' }}</span>
            </div>
        @endforeach
        <span>{{ $user->department->name ?? '' }} {{ $user->roles->first()->name }}</span>
    </div>
    <button
        onclick="Livewire.emit('slide-over.open', 'dealer.employee.edit', @js(['user' => $user->id]))"
        class="sm:order-0 order-1 ml-3 rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2 sm:ml-0">

        Edit
    </button>
</div>
