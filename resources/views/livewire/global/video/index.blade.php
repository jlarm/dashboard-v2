<div x-data="{ selectedCategory: '' }" class="space-y-5" wire:init="loadVideos">
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
        <!-- Loading Skeleton - Always rendered but conditionally shown -->
        <div x-show="$wire.isLoading" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @for ($i = 0; $i < 6; $i++)
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="animate-pulse">
                        <div class="bg-gray-200 h-40 w-full"></div>
                        <div class="p-4 space-y-3">
                            <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                            <div class="h-3 bg-gray-200 rounded w-1/2"></div>
                        </div>
                    </div>
                </div>
            @endfor
        </div>

        <!-- Actual content - Always rendered but conditionally shown -->
        <div x-show="!$wire.isLoading" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($videos as $video)
                <livewire:global.video.index-item
                    wire:key="video-{{ $video['id'] }}"
                    :videoId="$video['id']"
                    :videoTitle="$video['title']"
                    :videoCategory="$video['category']"
                    :videoThumbnail="$video['thumbnail']"
                    :videoProgress="$videoProgressMap[$video['id']] ?? null"
                />
            @endforeach
        </div>
    </div>
</div>
