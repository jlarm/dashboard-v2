<div class="grid grid-cols-1 lg:grid-cols-6 gap-4">
    <div class="col-span-4 bg-white rounded-md p-6">
        <h1 class="text-xl font-bold leading-none tracking-tight text-neutral-900">Permissions</h1>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mt-5">
            @forelse($items as $key => $item)
                <div class="border rounded-md p-3 hover:bg-gray-50">
                    <h1 class="font-semibold leading-6 text-gray-900 capitalize">{{ $key }}</h1>
                    @foreach($item as $i)
                        <p class="mt-1 flex items-center gap-x-2 text-sm leading-5 text-gray-500">{{ $i->name }}</p>
                    @endforeach
                    {{--                    @if($enableEditing)--}}

                    <button
                        class="text-red-500 text-sm"
                        wire:click="$emit('modal.open', 'central.permission.delete',  @js(['permission' => $key]))"
                    >
                        Delete
                    </button>
                    {{--                    @endif--}}
                </div>
            @empty
                <p>No Permissions Created</p>
            @endforelse
        </div>
    </div>
    <div class="col-span-2 bg-white rounded-md p-6">
        <h1 class="text-xl font-bold leading-none tracking-tight text-neutral-900 mb-3.5">Create Permission</h1>
        <livewire:central.permission.create/>
    </div>
</div>
