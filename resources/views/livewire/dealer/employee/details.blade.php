<div class="flex flex-col space-y-3">
    <div class="min-w-0 flex-1">
        <h1 class="text-2xl font-medium text-arm-blue-900 sm:truncate capitalize">{{ mb_convert_case($user->name, MB_CASE_TITLE, "UTF-8") }}</h1>
        <p class="text-sm text-gray-500">{{ $user->department->name ?? '' }} {{ $user->roles->first()->name ?? '' }}</p>
        <p class="text-sm text-gray-500">{{ $user->email }}</p>
    </div>
    <div class="">
        @foreach($user->stores as $store)
            <div>
                <span>{{ $store->name ?? '' }}</span>
            </div>
        @endforeach
    </div>
    <div class="flex gap-3">
        @if(auth()->user()->id != $user->id)
            <button onclick="Livewire.emit('slide-over.open', 'dealer.employee.edit', @js(['user' => $user->id]))" class="w-full rounded bg-arm-blue-600 px-2 py-1 text-sm font-semibold text-white shadow-sm hover:bg-arm-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-arm-blue-600">Edit</button>
            @can('create-stores')
            <button onclick="Livewire.emit('modal.open', 'dealer.employee.delete', @js(['user' => $user->id]))" class="w-full rounded bg-red-600 px-2 py-1 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">Delete</button>
            @endcan
        @endif
    </div>
</div>
