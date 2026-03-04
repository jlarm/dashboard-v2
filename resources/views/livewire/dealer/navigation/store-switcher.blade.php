@if($this->shouldDisplay)
<div class="relative mt-2"
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
             if (!this.open) {
                 return
             }
             this.open = false
             focusAfter && focusAfter.focus()
         }
     }"
     x-on:keydown.escape.prevent.stop="close($refs.button)"
     x-on:focusin.window="$refs.panel && !$refs.panel.contains($event.target) && close()"
     x-id="['dropdown-button']"
>
    <button
        id="combobox"
        x-ref="button"
        x-on:click="toggle()"
        :aria-expanded="open"
        :aria-controls="$id('dropdown-button')"
        type="button"
        class="group flex w-full items-center rounded-xl border border-gray-200 bg-gray-50 px-3 py-2.5 text-left transition hover:bg-white focus:outline-none focus:ring-2 focus:ring-arm-blue-600"
        role="combobox"
        aria-controls="options"
        aria-expanded="false"
    >
        <span class="min-w-0 flex-1 truncate text-base font-semibold text-gray-900">{{ $this->currentStoreDisplay }}</span>
    </button>

    <div
        x-ref="panel"
        x-show="open"
        x-transition.origin.top
        x-on:click.outside="close($refs.button)"
        :id="$id('dropdown-button')"
        style="display: none;"
        class="absolute z-20 mt-2 w-full overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-xl focus:outline-none"
    >
        <div class="px-4 pt-3 pb-2 text-xs font-semibold uppercase tracking-wide text-gray-500">stores</div>
        <ul class="max-h-64 space-y-1 overflow-auto px-2 pb-2" role="listbox">
            @if($this->canUseOverview)
                <li class="relative">
                    <button
                        type="button"
                        @if($currentStoreId !== null)
                            wire:click="switchToOverview"
                        @endif
                        @disabled($currentStoreId === null)
                        aria-disabled="{{ $currentStoreId === null ? 'true' : 'false' }}"
                        class="flex w-full items-center rounded-xl px-2.5 py-2 text-left text-sm transition {{ $currentStoreId === null ? 'cursor-default bg-gray-100 font-medium text-gray-900' : 'text-gray-800 hover:bg-gray-50' }}"
                    >
                        <span class="min-w-0 flex-1 truncate">Overview</span>
                    </button>
                </li>
            @endif

            @foreach($this->stores as $store)
                <li class="relative">
                    <button
                        type="button"
                        @if($currentStoreId !== $store->id)
                            wire:click="switchStore({{ $store->id }})"
                        @endif
                        @disabled($currentStoreId === $store->id)
                        aria-disabled="{{ $currentStoreId === $store->id ? 'true' : 'false' }}"
                        class="flex w-full items-center rounded-xl px-2.5 py-2 text-left text-sm transition {{ $currentStoreId === $store->id ? 'cursor-default bg-gray-100 font-medium text-gray-900' : 'text-gray-800 hover:bg-gray-50' }}"
                    >
                        <span class="min-w-0 flex-1 truncate">{{ Str::limit($store->name, 30) }}</span>
                    </button>
                </li>
            @endforeach
        </ul>
    </div>
</div>
@endif
