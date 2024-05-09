<div class="border rounded-md p-3 max-h-[300px] overflow-y-auto">
    <h2 class="text-sm font-semibold leading-6 text-gray-900">Activity</h2>
    <ul role="list" class="space-y-6 mt-2">
        @foreach($progress as $a)
            <li class="relative flex gap-x-4">
                @if(!$loop->last)
                    <div class="absolute left-0 top-0 flex w-6 justify-center -bottom-6">
                        <div class="w-px bg-gray-200"></div>
                    </div>
                @endif
                <div class="relative flex h-6 w-6 flex-none items-center justify-center bg-white">
                    <div class="h-1.5 w-1.5 rounded-full bg-gray-100 ring-1 ring-gray-300"></div>
                </div>
                <p class="flex-auto py-0.5 text-xs leading-5 text-gray-500">
                    <span class="font-medium text-gray-900">{{ $a->name }}</span>
                    {{ $a->status }}.
                </p>
                <time class="flex-none py-0.5 text-xs leading-5 text-gray-500">{{ $a->created_at->diffForHumans() }}</time>
            </li>
        @endforeach
    </ul>
</div>
