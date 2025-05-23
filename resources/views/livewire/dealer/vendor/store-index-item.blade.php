<li class="flex items-center justify-between gap-x-6 p-5 bg-gray-50 rounded-md">
    <div class="min-w-0">
        <div class="flex items-start gap-x-3">
            <p class="text-sm font-semibold leading-6 text-gray-900">{{ $vendor->name }}</p>
            @if(\Carbon\Carbon::now() <= $vendor->updated_at->addYear() && !$vendor->signature)
                <p class="rounded-md whitespace-nowrap mt-0.5 px-1.5 py-0.5 text-xs font-medium ring-1 ring-inset text-yellow-700 bg-yellow-50 ring-yellow-600/20">Incomplete</p>
            @elseif(\Carbon\Carbon::now() > $vendor->updated_at->addYear() && $vendor->signature)
                <p class="rounded-md whitespace-nowrap mt-0.5 px-1.5 py-0.5 text-xs font-medium ring-1 ring-inset text-red-700 bg-red-50 ring-red-600/20">Expired</p>
            @else
                <p class="rounded-md whitespace-nowrap mt-0.5 px-1.5 py-0.5 text-xs font-medium ring-1 ring-inset text-green-700 bg-green-50 ring-green-600/20">Current</p>
            @endif
        </div>
        <div class="mt-1 flex items-center gap-x-2 text-xs leading-5 text-gray-500">
            @if(\Carbon\Carbon::now() <= $vendor->updated_at->addYear() && $vendor->signature)
                <p class="whitespace-nowrap">Completed <time>{{ $vendor->updated_at->format('M d, Y') }}</time></p>
            @elseif(\Carbon\Carbon::now() > $vendor->updated_at->addYear() && $vendor->signature)
                <p class="whitespace-nowrap">Expired <time>{{ $vendor->updated_at->addYear()->format('M d, Y') }}</time></p>
            @else
                <p class="whitespace-nowrap">Sent <time>{{ $vendor->created_at->format('M d, Y') }}</time></p>
            @endif
            <svg viewBox="0 0 2 2" class="h-0.5 w-0.5 fill-current">
                <circle cx="1" cy="1" r="1" />
            </svg>
            <p class="truncate">To {{ $vendor->contact_name }}</p>
            @if($noCount > 0)
                <svg viewBox="0 0 2 2" class="h-0.5 w-0.5 fill-current">
                    <circle cx="1" cy="1" r="1" />
                </svg>
                <p class="truncate text-red-500">{{ $noCount }} No's</p>
            @endif
        </div>
    </div>
    <div class="flex flex-none items-center gap-x-4">
        <div
            x-data="{
                open: false,
                toggle() {
                    if (this.open) {
                        return this.close()
                    }
                    this.$refs.button.focus()
                    this.open = true
                },
                close(focusAfter) {
                    if (! this.open) return
                    this.open = false
                    focusAfter && focusAfter.focus()
                }
            }"
            x-on:keydown.escape.prevent.stop="close($refs.button)"
            x-on:focusin.window="$refs.panel && !$refs.panel.contains($event.target) && close()"
            x-id="['dropdown-button']"
            class="relative flex-none"
        >
            <button
                x-ref="button"
                x-on:click="toggle()"
                :aria-expanded="open"
                :aria-controls="$id('dropdown-button')"
                type="button"
                class="-m-2.5 block p-2.5 text-gray-500 hover:text-gray-900"
                id="options-menu-0-button"
                aria-expanded="false"
                aria-haspopup="true"
            >
                <span class="sr-only">Open options</span>
                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path d="M10 3a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM10 8.5a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM11.5 15.5a1.5 1.5 0 10-3 0 1.5 1.5 0 003 0z" />
                </svg>
            </button>
            <div
                x-ref="panel"
                x-show="open"
                x-transition.origin.top.left
                x-on:click.outside="close($refs.button)"
                :id="$id('dropdown-button')"
                style="display: none;"
                class="absolute right-0 z-10 mt-2 w-32 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5 focus:outline-none"
                role="menu"
                aria-orientation="vertical"
                aria-labelledby="options-menu-0-button"
                tabindex="-1"
            >
                @if($vendor->signature)
                    <button
                        wire:click.prevent="download"
                        type="button"
                        class="block px-3 py-1 text-sm leading-6 text-gray-900"
                        tabindex="-1"
                        id="options-menu-0-item-0"
                    >
                        Download
                    </button>
                @endif
                @can('create-stores')
                    <button
                        wire:click="$emit('modal.open', 'dealer.vendor.edit',  @js(['vendor' => $vendor->id]))"
                        class="block px-3 py-1 text-sm leading-6 text-gray-900"
                        tabindex="-1"
                        id="options-menu-0-item-2"
                    >
                        Edit
                    </button>
                <button
                    wire:click="$emit('modal.open', 'dealer.vendor.delete',  @js(['vendor' => $vendor->id]))"
                    class="block px-3 py-1 text-sm leading-6 text-gray-900"
                    tabindex="-1"
                    id="options-menu-0-item-2"
                >
                    Delete
                </button>
                @endcan
            </div>
        </div>
    </div>
</li>
