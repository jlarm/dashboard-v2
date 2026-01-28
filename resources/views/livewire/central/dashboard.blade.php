<div>
    <div class="max-w-md mx-auto">
        <h1 class="text-lg text-arm-blue-900 font-bold border-b">Quick Links</h1>
        <ul class="divide-y divide-gray-200">
            @foreach($dealerships as $dealership)
                <li class="flex items-center justify-between gap-x-6 py-3">
                    <p class="text-sm">{{ $dealership->name }}</p>
                    <a target="_blank" href="https://{{ $dealership->domain() }}/dashboard" class="relative items-center justify-center inline-flex gap-1 text-xs h-8 border border-zinc-200 rounded-md px-2 hover:bg-zinc-100 transition">
                        View
                        <svg class="size-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" color="currentColor" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17.5 6.5L6 18" />
                            <path d="M8 6H18V16" />
                        </svg>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>
