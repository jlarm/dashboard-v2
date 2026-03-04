<div class="relative"
     x-data="{
         open: false,
         showCoachMark: false,
         coachMarkStorageKey: @js('store-switcher-coach-mark:'.tenant('id').':'.auth()->id()),
         init() {
             if (! @js($this->shouldShowCoachMark)) {
                 return
             }

             this.showCoachMark = !this.isCoachMarkDismissed()
         },
         isCoachMarkDismissed() {
             try {
                 return window.localStorage.getItem(this.coachMarkStorageKey) === 'dismissed'
             } catch (error) {
                 return false
             }
         },
         dismissCoachMark() {
             this.showCoachMark = false

             try {
                 window.localStorage.setItem(this.coachMarkStorageKey, 'dismissed')
             } catch (error) {
             }
         },
         toggle() {
             if (this.open) {
                 return this.close()
             }
             this.dismissCoachMark()
             this.$refs.button.focus()
             this.open = true
         },
         close(focusAfter) {
             if (!this.open) {
                 return
             }
             this.open = false
             focusAfter && focusAfter.focus()
         }
     }"
     x-on:keydown.escape.prevent.stop="close($refs.button)"
     x-on:focusin.window="$refs.panel && !$refs.panel.contains($event.target) && close()"
     x-id="['current-store-dropdown']"
>
    <button
        id="current-store-combobox"
        x-ref="button"
        x-on:click="toggle()"
        :aria-expanded="open"
        :aria-controls="$id('current-store-dropdown')"
        type="button"
        @disabled(! $this->shouldDisplay)
        class="inline-flex items-center gap-2 rounded-lg bg-white px-3 py-1.5 text-left text-arm-blue-500 transition {{ $this->shouldDisplay ? 'hover:bg-gray-100' : 'cursor-default' }}"
        :class="showCoachMark ? 'ring-2 ring-orange-300 ring-offset-2 ring-offset-white shadow-sm' : ''"
        role="combobox"
        aria-controls="options"
        aria-expanded="false"
    >
        <span class="truncate">{{ $this->currentStoreDisplay }}</span>
        @if($this->shouldShowCoachMark)
            <span x-cloak x-show="showCoachMark" class="relative flex h-2.5 w-2.5" aria-hidden="true">
                <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-orange-400 opacity-75"></span>
                <span class="relative inline-flex h-2.5 w-2.5 rounded-full bg-orange-500"></span>
            </span>
        @endif
        @if($this->shouldDisplay)
            <svg data-switcher-icon class="h-4 w-4 text-arm-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20" stroke-width="2" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 7l4-4 4 4"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M14 13l-4 4-4-4"/>
            </svg>
        @endif
    </button>

    @if($this->shouldShowCoachMark)
        <div
            x-cloak
            x-show="showCoachMark"
            x-transition.opacity.duration.200ms
            class="absolute left-0 top-full z-50 mt-3 w-80 max-w-[calc(100vw-2rem)]"
            role="dialog"
            aria-label="Store switcher tip"
        >
            <div class="absolute left-6 top-0 h-3 w-3 -translate-y-1/2 rotate-45 rounded-sm border-l border-t border-orange-200 bg-white"></div>
            <div class="rounded-2xl border border-orange-200 bg-white p-4 shadow-xl shadow-orange-100/60">
                <p class="text-sm font-semibold text-gray-900">Store switching moved here</p>
                <p class="mt-1 text-sm leading-5 text-gray-600">
                    Use this menu any time you need to jump between your stores.
                </p>
                <div class="mt-3 flex items-center gap-2">
                    <button
                        type="button"
                        x-on:click="dismissCoachMark()"
                        class="inline-flex items-center rounded-lg bg-arm-blue-500 px-3 py-1.5 text-sm font-medium text-white transition hover:bg-arm-blue-600"
                    >
                        Got it
                    </button>
                    <button
                        type="button"
                        x-on:click="dismissCoachMark(); toggle()"
                        class="inline-flex items-center rounded-lg px-3 py-1.5 text-sm font-medium text-arm-blue-500 transition hover:bg-gray-100"
                    >
                        Open switcher
                    </button>
                </div>
            </div>
        </div>
    @endif

    @if($this->shouldDisplay)
        <div
            x-cloak
            x-ref="panel"
            x-show="open"
            x-transition.origin.top.left
            x-on:click.outside="close($refs.button)"
            :id="$id('current-store-dropdown')"
            style="display: none;"
            class="absolute left-0 z-40 mt-2 w-80 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-lg"
        >
            <ul class="max-h-64 overflow-auto border-t border-gray-100 py-1" role="listbox">
                @if($this->canUseOverview)
                    <li>
                        <button
                            type="button"
                            @if($currentStoreId !== null)
                                wire:click="switchToOverview"
                            @endif
                            @disabled($currentStoreId === null)
                            aria-disabled="{{ $currentStoreId === null ? 'true' : 'false' }}"
                            class="flex w-full items-center gap-2 px-3 py-2 text-left text-sm text-gray-800 transition {{ $currentStoreId === null ? 'cursor-default bg-gray-50' : 'hover:bg-gray-50' }}"
                        >
                            <span class="w-4 text-center text-gray-800">
                                @if($currentStoreId === null)
                                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd"/>
                                    </svg>
                                @endif
                            </span>
                            <span class="{{ $currentStoreId === null ? 'font-semibold text-gray-900' : '' }}">Overview</span>
                        </button>
                    </li>
                @endif

                @foreach($this->stores as $store)
                    <li>
                        <button
                            type="button"
                            @if($currentStoreId !== $store->id)
                                wire:click="switchStore({{ $store->id }})"
                            @endif
                            @disabled($currentStoreId === $store->id)
                            aria-disabled="{{ $currentStoreId === $store->id ? 'true' : 'false' }}"
                            class="flex w-full items-center gap-2 px-3 py-2 text-left text-sm text-gray-800 transition {{ $currentStoreId === $store->id ? 'cursor-default bg-gray-50' : 'hover:bg-gray-50' }}"
                        >
                            <span class="w-4 text-center text-gray-800">
                                @if($currentStoreId === $store->id)
                                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd"/>
                                    </svg>
                                @endif
                            </span>
                            <span class="{{ $currentStoreId === $store->id ? 'font-semibold text-gray-900' : '' }}">{{ Str::limit($store->name, 30) }}</span>
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
