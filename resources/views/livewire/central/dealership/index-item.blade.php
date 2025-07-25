<div class="group relative overflow-hidden flex flex-col justify-between rounded-lg border border-gray-200 bg-white shadow-sm transition-all hover:shadow-md">
    <div class="p-6">
        <div class="flex items-start justify-between gap-3">
            <h3 class="text-lg font-medium text-gray-900 truncate min-w-0 flex-1">{{ $dealership->name }}</h3>
            @role('super-admin')
                <div
                    x-data="{
                        dealershipId: '{{ $dealership->id }}',
                        copied: false,
                        timeout: null,
                        copyToClipboard() {
                            $clipboard(this.dealershipId);
                            this.copied = true;
                            clearTimeout(this.timeout);
                            this.timeout = setTimeout(() => {
                                this.copied = false;
                            }, 2000);
                        }
                    }"
                    class="ml-4"
                >
                    <button
                        type="button"
                        @click="copyToClipboard"
                        class="group/button relative inline-flex items-center gap-1.5 rounded-md bg-gray-50 px-2.5 py-1.5 text-xs font-mono text-gray-600 ring-1 ring-inset ring-gray-200 transition-all hover:bg-gray-100 hover:ring-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1"
                        :class="{ 'bg-green-50 ring-green-200 text-green-700': copied }"
                    >
                        <span class="truncate max-w-[120px]">{{ $dealership->id }}</span>
                        
                        {{-- Copy Icon --}}
                        <svg
                            x-show="!copied"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="h-3.5 w-3.5 text-gray-400 transition-colors group-hover/button:text-gray-600"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0 0 13.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 0 1-.75.75H9a.75.75 0 0 1-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 0 1 1.927-.184" />
                        </svg>
                        
                        {{-- Success Checkmark Icon --}}
                        <svg
                            x-show="copied"
                            x-cloak
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="2"
                            stroke="currentColor"
                            class="h-3.5 w-3.5 text-green-600"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                        </svg>
                    </button>
                </div>
            @endrole
        </div>
        
        @role('super-admin')
            @if($dealership->users->isNotEmpty())
                <div class="mt-4">
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
                </div>
            @endif
        @endrole
    </div>
    <div class="border-t border-gray-100 bg-gray-50 p-3">
        <div class="flex gap-2">
            @can('edit-dealership')
                <button
                    type="button"
                    wire:click="$emit('slide-over.open', 'central.dealership.edit', @js(['dealership' => $dealership->id]))"
                    class="inline-flex flex-1 items-center justify-center rounded-md bg-white px-2.5 py-1.5 text-sm font-medium text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 transition-colors hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                >
                    Edit
                </button>
            @endcan
            
            <a
                href="https://{{ $dealership->domain }}/dashboard"
                target="_blank"
                rel="noopener noreferrer"
                class="inline-flex flex-1 items-center justify-center rounded-md bg-arm-blue-600 px-2.5 py-1.5 text-sm font-medium text-white shadow-sm transition-colors hover:bg-arm-blue-700 focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2"
            >
                View
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="ml-1 h-3.5 w-3.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                </svg>
            </a>
        </div>
        
        @can('delete-dealership')
            @if(app()->environment('local'))
                <button
                    type="button"
                    wire:click="deleteDealership"
                    wire:confirm="Are you sure you want to delete this dealership and its database? This action cannot be undone."
                    class="mt-2 inline-flex w-full items-center justify-center rounded-md bg-red-600 px-2.5 py-1.5 text-sm font-medium text-white shadow-sm transition-colors hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                >
                    Delete
                </button>
            @endif
        @endcan
    </div>
</div>