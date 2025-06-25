<div x-data="{ selectedCategory: '' }" class="space-y-5">
    <div class="flex justify-between items-center">
        <div class="sm:flex-auto">
            <h1 class="text-xl font-bold leading-none tracking-tight text-neutral-900">Training Videos</h1>
            <p class="text-sm text-gray-500 mt-1">These videos will be accessible to all dealerships.</p>
        </div>
        <div>
            <select x-model="selectedCategory" class="text-sm rounded-md border-gray-300 shadow-sm focus:border-arm-blue-300 focus:ring focus:ring-arm-blue-200 focus:ring-opacity-50">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category }}">{{ $category }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="mt-5">
        <div class="grid grid-cols-3 gap-5">
            @foreach($videos as $video)
                <livewire:global.video.index-item
                    wire:key="video-{{ $video['id'] }}"
                    :videoId="$video['id']"
                    :videoTitle="$video['title']"
                    :videoCategory="$video['category']"
                    :videoThumbnail="$video['thumbnail']"
                />
            @endforeach
        </div>
    </div>
</div>
