<div class="lg:flex items-center justify-between mb-5 bg-gray-50 p-4 rounded border-b border-gray-200 sticky">
    <div>
        <span class="text-3xl font-black text-arm-orange-500">{{ $store->name }}</span>
        <nav class="flex grow border-b border-white/10 py-2">
            <ul role="list"
                class="flex gap-x-6 text-sm font-semibold leading-6">

                <li>
                    <a
                        class="{{ (request()->segment(3) == '') ? 'text-arm-blue-600' : 'text-gray-400 hover:text-arm-blue-600' }}"
                        href="{{ route('dealer.stores.home', $store) }}">Home</a>
                </li>

                <li>
                    <a
                        class="{{ (request()->segment(3) == 'employees') ? 'text-arm-blue-600' : 'text-gray-400 hover:text-arm-blue-600' }}"
                        href="{{ route('dealer.stores.employees', $store) }}">Employees</a>
                </li>

                <li>
                    <a
                        class="{{ (request()->segment(3) == 'scans') ? 'text-arm-blue-600' : 'text-gray-400 hover:text-arm-blue-600' }}"
                        href="{{ route('dealer.stores.scans', $store) }}">IT Scans</a>
                </li>

                <li>
                    <a
                        class="{{ (request()->segment(3) == 'manuals') ? 'text-arm-blue-600' : 'text-gray-400 hover:text-arm-blue-600' }}"
                        href="{{ route('dealer.stores.manuals', $store) }}">Manuals</a>
                </li>

                <li x-data="{ open: false }" class="relative">
                    <button
                        @click="open = !open"
                        class="{{ (request()->segment(3) == 'audits') ? 'text-arm-blue-600' : 'text-gray-400 hover:text-arm-blue-600' }} flex items-center gap-x-1"
                    >
                        Audits
                        <svg class="h-5 w-5 flex-none text-gray-400" viewBox="0 0 20 20" fill="currentColor"
                             aria-hidden="true">
                            <path fill-rule="evenodd"
                                  d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                  clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <div
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-1"
                        x-show="open"
                        class="x-cloak absolute -left-8 top-full z-10 mt-3 w-56 rounded-xl bg-white p-2 shadow-lg ring-1 ring-gray-900/5"
                        x-ref="panel"
                        @click.away="open = false"
                        x-cloak
                    >
                        <a href="{{ route('dealer.stores.audits.osha.index', $store) }}"
                           class="block rounded-lg px-3 py-2 text-sm leading-6 text-arm-blue-500 hover:bg-arm-blue-50">OSHA</a>
                        <a href="{{ route('dealer.stores.audits.body-shop.index', $store) }}"
                           class="block rounded-lg px-3 py-2 text-sm leading-6 text-arm-blue-500 hover:bg-arm-blue-50">Body
                            Shop</a>
                        <a href="{{ route('dealer.stores.audits.finance.index', $store) }}"
                           class="block rounded-lg px-3 py-2 text-sm leading-6 text-arm-blue-500 hover:bg-arm-blue-50">GLBA
                            Walkthrough</a>
                        <a href="{{ route('dealer.stores.audits.individual.index', $store) }}"
                           class="block rounded-lg px-3 py-2 text-sm leading-6 text-arm-blue-500 hover:bg-arm-blue-50">Deal
                            Jackets</a>
                    </div>
                </li>

                <li>
                    <a
                        class="{{ (request()->segment(3) == 'settings') ? 'text-arm-blue-600' : 'text-gray-400 hover:text-arm-blue-600' }}"
                        href="{{ route('dealer.stores.settings', $store) }}">Settings</a>
                </li>

            </ul>
        </nav>
    </div>

    <div class="flex flex-row-reverse items-end">
        @if(tenant('locations'))
            @can('view-audits')
                <livewire:dealer.general.soc-monitoring-multi-store :store="$store"/>
            @endcan
        @endif
        @if($storeCount > 1)
            <div class="flex justify-center">
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
                    class="relative"
                >
                    <!-- Button -->
                    <button
                        x-ref="button"
                        x-on:click="toggle()"
                        :aria-expanded="open"
                        :aria-controls="$id('dropdown-button')"
                        type="button"
                        class="flex items-center gap-2 bg-white px-5 py-2.5 rounded-md shadow text-sm"
                    >
                        Switch Store

                        <!-- Heroicon: chevron-down -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                             fill="currentColor">
                            <path fill-rule="evenodd"
                                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </button>

                    <!-- Panel -->
                    <div
                        x-ref="panel"
                        x-show="open"
                        x-transition.origin.top.left
                        x-on:click.outside="close($refs.button)"
                        :id="$id('dropdown-button')"
                        style="display: none;"
                        class="absolute left-0 mt-2 w-40 rounded-md bg-white shadow-md"
                    >
                        @foreach($stores as $store)
                            <a href="{{ route('dealer.stores.home', $store) }}"
                               class="flex items-center gap-2 w-full first-of-type:rounded-t-md last-of-type:rounded-b-md px-4 py-2.5 text-left text-sm hover:bg-gray-50 disabled:text-gray-500">
                                {{ $store->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
