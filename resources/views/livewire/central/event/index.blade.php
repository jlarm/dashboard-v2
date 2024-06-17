<ul role="list" class="divide-y divide-gray-100">
    @forelse($events as $event)
        <li>
            <a class="flex justify-between gap-x-6 py-5" @if($event->link) href="{{ $event->link }}" @endif target="_blank">
                <div class="flex min-w-0 gap-x-4">
                    <div class="min-w-0 flex-auto">
                        <p class="text-sm font-semibold leading-6 text-gray-900">{{ $event->name }}</p>
                        <p class="mt-1 truncate text-xs leading-5 text-gray-500">
                            {{ $event->start_date->format('F d, Y') }}
                            @if($event->start_date->format('Y-m-d') != $event->end_date->format('Y-m-d'))
                                - {{ $event->end_date->format('F d, Y') }}
                            @endif
                        </p>
                    </div>
                </div>
                <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                    <p class="text-sm leading-6 text-gray-900">{{ $event->location_name }}</p>
                    <p class="mt-1 text-xs leading-5 text-gray-500">{{ $event->city }}, {{ $event->state }}
                    </p>
                </div>
            </a>
        </li>
    @empty
        <p class="mt-10 mb-3">No Upcoming Events</p>
    @endforelse
</ul>
