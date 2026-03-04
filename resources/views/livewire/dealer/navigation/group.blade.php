<div class="px-3 mb-1.5">
    <div x-data="{ open: @js($item['open']) }">
        <button
            class="{{ $item['active'] ? 'bg-gray-100 text-gray-600' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }} w-full border-transparent group flex items-center rounded-lg py-1.5 px-2.5 text-[13px]"
            type="button"
            @click="open = !open"
        >
            @include('livewire.dealer.navigation.icon', ['name' => $item['icon'], 'active' => $item['active']])
            {{ $item['label'] }}
            <svg class="ml-auto h-4 w-4 shrink-0 text-gray-400" :class="{ '-rotate-180 text-gray-500': open, 'text-gray-400': ! open }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="none">
                <path d="M6 9.00005L12 15L18 9" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="16" />
            </svg>
        </button>

        <ul
            x-cloak
            class="mt-1 ml-6 space-y-1 border-l-2 border-gray-100"
            x-show="open"
        >
            @foreach($item['children'] as $child)
                <li>
                    <a
                        href="{{ $child['href'] }}"
                        class="{{ $child['active'] ? 'bg-gray-100' : '' }} ml-3 block rounded-lg py-1.5 px-2.5 text-[13px] leading-5 text-gray-700 hover:bg-gray-100"
                    >
                        {{ $child['label'] }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>
