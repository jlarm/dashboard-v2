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
    <input
        id="combobox"
        value="{{ $this->currentStoreDisplay }}"
        type="text"
        readonly
        class="w-full rounded-md border-0 bg-white py-1.5 pl-3 pr-8 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"
        role="combobox"
        aria-controls="options"
        aria-expanded="false"
    >

    <button
        x-ref="button"
        x-on:click="toggle()"
        :aria-expanded="open"
        :aria-controls="$id('dropdown-button')"
        type="button"
        class="absolute inset-y-0 right-0 flex w-full items-center justify-end rounded-r-md px-2 focus:outline-none"
    >
        <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path
                fill-rule="evenodd"
                d="M10 3a.75.75 0 01.55.24l3.25 3.5a.75.75 0 11-1.1 1.02L10 4.852 7.3 7.76a.75.75 0 01-1.1-1.02l3.25-3.5A.75.75 0 0110 3zm-3.76 9.2a.75.75 0 011.06.04l2.7 2.908 2.7-2.908a.75.75 0 111.1 1.02l-3.25 3.5a.75.75 0 01-1.1 0l-3.25-3.5a.75.75 0 01.04-1.06z"
                clip-rule="evenodd"
            />
        </svg>
    </button>

    <ul
        x-ref="panel"
        x-show="open"
        x-transition.origin.top.left
        x-on:click.outside="close($refs.button)"
        :id="$id('dropdown-button')"
        style="display: none;"
        class="absolute z-10 mt-1 max-h-56 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
        role="listbox"
    >
        @if($this->stores->count() > 1 && $currentStoreName)
            <li
                class="relative cursor-default select-none p-2 text-gray-900 hover:bg-gray-50"
                role="option"
                tabindex="-1"
            >
                <a href="{{ route('dealer.dashboard') }}" class="block">
                    <div class="flex items-center">
                        <span>All Stores</span>
                    </div>
                </a>
            </li>
        @endif

        @foreach($this->stores as $store)
            <li
                class="relative cursor-default select-none p-2 text-gray-900 hover:bg-gray-50"
                role="option"
                tabindex="-1"
            >
                <a href="{{ route('dealer.stores.home', $store) }}" class="block">
                    <div class="flex items-center">
                        <span>{{ Str::limit($store->name, 30) }}</span>
                    </div>

                    @if($currentStoreName === $store->name)
                        <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-arm-blue-600">
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path
                                    fill-rule="evenodd"
                                    d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        </span>
                    @endif
                </a>
            </li>
        @endforeach
    </ul>
</div>
