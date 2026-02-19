<div class="max-w-2xl mx-auto mt-5">
    @if(! $isLoaded)
        <div class="rounded-lg border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600">
            Select the "Video Training Progress" tab to load video completion data.
        </div>
    @else
    <div class="flex flex-col">
        @foreach($videos as $video)
        <div class="flex justify-between gap-5 py-2.5 first:pt-0 last:pb-0 first:border-t-0 border-t border-dashed border-gray-200">
            <div class="grow">
              <span class="block text-sm text-gray-800">
                {{ Str::limit($video['title'], 50) }}
              </span>
                <small class="block text-xs text-gray-500">
                    {{ $video['category'] }}
                </small>
            </div>

            <div class="min-w-22 flex items-center gap-x-1.5 whitespace-nowrap">
                <div class="flex items-center gap-2">
                    <div class="grow">
                      @if($video['completed'])
                            <div class="flex justify-center items-center gap-x-1 whitespace-nowrap">
                                <svg class="shrink-0 size-3.5 text-green-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
                                <small class="block text-xs text-gray-500 dark:text-neutral-400">
                                    Completed {{ $video['date']->diffForHumans() }}
                                </small>
                            </div>
                      @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
