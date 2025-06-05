<x-wire-elements-pro::tailwind.modal
    :content-padding="false"
>
    <div class="relative z-10" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-25 transition-opacity"></div>
        <div class="mx-auto max-w-xl transform divide-y divide-gray-100 overflow-hidden rounded-xl bg-white shadow-2xl ring-1 ring-black ring-opacity-5 transition-all">
            <div class="relative">
                <svg class="pointer-events-none absolute left-4 top-3.5 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                </svg>
                <label>
                    <input
                        wire:model="search"
                        type="text"
                        class="h-12 w-full border-0 bg-transparent pl-11 pr-4 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm"
                        placeholder="Search Violations..."
                        autofocus
                    />
                </label>
            </div>

            <!-- Results, show/hide based on command palette state -->
            @if(strlen($search) >= 2)
                <ul class="max-h-64 scroll-py-2 overflow-y-auto py-2 text-sm text-gray-800" id="options" role="listbox">
                    @if(count($violations) > 0)
                        @foreach($violations as $violation)
                            <li wire:click="selectViolation({{ $violation->id }})" class="cursor-default select-none px-4 py-2 hover:bg-arm-blue-500 hover:cursor-pointer hover:text-white" id="option-1" role="option" tabindex="-1">
                                {{ $violation->statement }}</li>
                        @endforeach
                    @endif
                </ul>
            @elseif (empty($violations) || count($violations) === 0)
            @else
                <!-- Empty state, show/hide based on command palette state -->
                <p class="p-4 text-sm text-gray-500">No results found.</p>
            @endif
        </div>
    </div>
</x-wire-elements-pro::tailwind.modal>
