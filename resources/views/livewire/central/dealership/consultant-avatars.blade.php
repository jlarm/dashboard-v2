<div class="flex items-center -space-x-2">
    @foreach($dealership->users as $user)
        <div class="relative" x-data="{ showTooltip: false }">
            <button
                type="button"
                class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-gray-100 text-xs font-medium text-gray-800 ring-2 ring-white transition-all hover:bg-gray-200 hover:ring-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                @mouseenter="showTooltip = true"
                @mouseleave="showTooltip = false"
                aria-label="{{ $user->name }}"
            >
                {{ $user->initials }}
            </button>
            <div
                x-show="showTooltip"
                x-cloak
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-95"
                class="absolute bottom-full left-1/2 z-10 mb-2 -translate-x-1/2 whitespace-nowrap rounded-md bg-gray-900 px-2 py-1 text-xs font-medium text-white shadow-lg"
            >
                {{ $user->name }}
                <div class="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-gray-900"></div>
            </div>
        </div>
    @endforeach
</div>
