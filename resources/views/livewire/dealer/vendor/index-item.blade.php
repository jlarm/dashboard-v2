<tr>
    <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm text-gray-500 sm:pl-0">
        {{ $vendor->name }}
    </td>
    <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-900">
        {{ $vendor->contact_name ?? '-' }}
        <a class="block text-xs text-gray-400" href="mailto:{{ $vendor->contact_email }}">{{ $vendor->contact_email }}</a>
    </td>
    <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-900">
        @if(\Carbon\Carbon::now() <= $vendor->updated_at->addYear() && $vendor->signature)
            <p class="whitespace-nowrap">Completed <time>{{ $vendor->updated_at->format('M d, Y') }}</time></p>
        @elseif(\Carbon\Carbon::now() > $vendor->updated_at->addYear() && $vendor->signature)
            <p class="whitespace-nowrap">Expired <time>{{ $vendor->updated_at->addYear()->format('M d, Y') }}</time></p>
        @else
            <p class="whitespace-nowrap">Sent <time>{{ $vendor->created_at->format('M d, Y') }}</time></p>
        @endif
    </td>
    <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-900">
        @if(\Carbon\Carbon::now() <= $vendor->updated_at->addYear() && !$vendor->signature)
            <span
                class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-yellow-700 ring-1 ring-inset ring-yellow-600/10">Incomplete</span>
        @elseif(\Carbon\Carbon::now() > $vendor->updated_at->addYear() && $vendor->signature)
            <span
                class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">Expired</span>
        @else
            <span
                class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Current</span>
        @endif
    </td>
    <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-900">
        @if($noCount > 0)
            {{ $noCount }}/{{ $totalQuestions }}
        @else
            {{ __('-') }}
        @endif
    </td>
    <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-900">
        <div class="flex space-x-3 justify-end items-end">
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
                    x-on:focusin.window="! $refs.panel.contains($event.target) && close()"
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
        </div>
    </td>
</tr>
