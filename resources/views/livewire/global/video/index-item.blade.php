<a
    href="{{ route('videos.show', $videoId) }}"
    class="hover:bg-gray-100 p-2 rounded-xl"
    x-show="selectedCategory === '' || selectedCategory === '{{ $videoCategory }}'"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform scale-90"
    x-transition:enter-end="opacity-100 transform scale-100"
>
    <div class="relative">
        <img src="{{ $videoThumbnail }}" alt="Thumbnail" class="rounded-xl w-full mb-2">
        @if($videoProgress && $videoProgress->completed)
            <div class="absolute top-2 right-2 bg-green-500 text-white text-xs px-2 py-1 rounded-full">
                Completed
            </div>
        @endif
    </div>
    <div class="flex justify-between">
        <h2 class="text-sm font-semibold">{{ \Str::limit($videoTitle, 25) }}</h2>
        <p class="text-sm text-gray-600">{{ $videoCategory }}</p>
    </div>
</a>
