<div class="flex flex-col gap-4 lg:flex-row lg:gap-6 lg:items-start">
    <div class="w-full  lg:shrink-0 rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
        <h1 class="mb-1 text-base font-semibold text-gray-900">Quick Links</h1>
        <ul class="mt-2 divide-y divide-gray-100">
            @foreach($dealerships as $dealership)
                <li class="flex items-center justify-between gap-4 py-2.5">
                    <p class="text-sm text-gray-700 truncate">{{ $dealership->name }}</p>
                    <a target="_blank" href="https://{{ $dealership->domain() }}/dashboard"
                       class="shrink-0 inline-flex items-center gap-1 rounded-md border border-gray-200 px-2 py-1 text-xs text-gray-600 hover:bg-gray-50 transition">
                        View
                        <svg class="size-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17.5 6.5L6 18"/><path d="M8 6H18V16"/>
                        </svg>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

{{--    <div class="min-w-0 flex-1 rounded-xl border border-gray-200 bg-white p-4 shadow-sm">--}}
{{--        <livewire:central.upcoming-audits />--}}
{{--    </div>--}}
</div>
