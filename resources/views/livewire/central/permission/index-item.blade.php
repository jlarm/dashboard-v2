<div class="border rounded-md p-3">
    <h1 class="whitespace-nowrap py-2 pl-4 pr-3 text-sm text-gray-500 sm:pl-0">{{ $key }}</h1>
    @foreach($item as $i)
        {{ $i->name }}<br/>
    @endforeach
    {{--    <td class="relative whitespace-nowrap py-2 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">--}}
    {{--        @if($enableEditing)--}}
    {{--            <button--}}
    {{--                class="text-red-500 text-sm"--}}
    {{--                wire:click="$emit('modal.open', 'central.permission.delete',  @js(['permission' => $permission->id]))"--}}
    {{--            >--}}
    {{--                Delete--}}
    {{--            </button>--}}
    {{--        @endif--}}
    {{--    </td>--}}
</div>
