<div class="px-4 sm:px-6 lg:px-8">
    <div class="flow-root">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle">
                <!-- Tabs -->
                <div
                    x-data="{
                        selectedId: null,
                        init() {
                            // Set the first available tab on the page on page load.
                            this.$nextTick(() => this.select(this.$id('tab', 1)))
                        },
                        select(id) {
                            this.selectedId = id
                        },
                        isSelected(id) {
                            return this.selectedId === id
                        },
                        whichChild(el, parent) {
                            return Array.from(parent.children).indexOf(el) + 1
                        }
                    }"
                    x-id="['tab']"
                    class="mx-5"
                >
                    <!-- Tab List -->
                    <ul
                        x-ref="tablist"
                        @keydown.right.prevent.stop="$focus.wrap().next()"
                        @keydown.home.prevent.stop="$focus.first()"
                        @keydown.page-up.prevent.stop="$focus.first()"
                        @keydown.left.prevent.stop="$focus.wrap().prev()"
                        @keydown.end.prevent.stop="$focus.last()"
                        @keydown.page-down.prevent.stop="$focus.last()"
                        role="tablist"
                        class="-mb-px flex items-stretch"
                    >
                        <!-- Tab -->
                        <li>
                            <button
                                :id="$id('tab', whichChild($el.parentElement, $refs.tablist))"
                                @click="select($el.id)"
                                @mousedown.prevent
                                @focus="select($el.id)"
                                type="button"
                                :tabindex="isSelected($el.id) ? 0 : -1"
                                :aria-selected="isSelected($el.id)"
                                :class="isSelected($el.id) ? 'border-gray-200 bg-white' : 'border-transparent'"
                                class="inline-flex rounded-t-md border-t border-l border-r px-5 py-2.5"
                                role="tab"
                            >External Scans
                            </button>
                        </li>

                        <li>
                            <button
                                :id="$id('tab', whichChild($el.parentElement, $refs.tablist))"
                                @click="select($el.id)"
                                @mousedown.prevent
                                @focus="select($el.id)"
                                type="button"
                                :tabindex="isSelected($el.id) ? 0 : -1"
                                :aria-selected="isSelected($el.id)"
                                :class="isSelected($el.id) ? 'border-gray-200 bg-white' : 'border-transparent'"
                                class="inline-flex rounded-t-md border-t border-l border-r px-5 py-2.5"
                                role="tab"
                            >Internal Scans
                            </button>
                        </li>
                        @if(tenant('id') != 'e44653a5-c049-4be0-92e3-b8aacea4bf20')
                            <li>
                                <button
                                    :id="$id('tab', whichChild($el.parentElement, $refs.tablist))"
                                    @click="select($el.id)"
                                    @mousedown.prevent
                                    @focus="select($el.id)"
                                    type="button"
                                    :tabindex="isSelected($el.id) ? 0 : -1"
                                    :aria-selected="isSelected($el.id)"
                                    :class="isSelected($el.id) ? 'border-gray-200 bg-white' : 'border-transparent'"
                                    class="inline-flex rounded-t-md border-t border-l border-r px-5 py-2.5"
                                    role="tab"
                                >Settings
                                </button>
                            </li>
                        @endif
                    </ul>

                    <!-- Panels -->
                    <div role="tabpanels" class="rounded-b-md border border-gray-200 bg-white">
                        <!-- Panel -->
                        <section
                            x-show="isSelected($id('tab', whichChild($el, $el.parentElement)))"
                            :aria-labelledby="$id('tab', whichChild($el, $el.parentElement))"
                            role="tabpanel"
                            class="p-8"
                        >
                            @if(tenant('id') != 'e44653a5-c049-4be0-92e3-b8aacea4bf20')
                                @role('super-admin|Consultant')
                                @if(Cookie::get('sentry'))
                                    <livewire:dealer.scan.index :store="$store"/>
                                @else
                                    <div class="max-w-md mx-auto">
                                        <livewire:dealer.scan.login :store="$store"/>
                                    </div>
                                @endif
                                @endrole
                            @endif
                            <livewire:dealer.scan.report-index :store="$store"/>
                        </section>

                        <section
                            x-show="isSelected($id('tab', whichChild($el, $el.parentElement)))"
                            :aria-labelledby="$id('tab', whichChild($el, $el.parentElement))"
                            role="tabpanel"
                            class="p-8"
                        >
                            @if(tenant('id') != 'e44653a5-c049-4be0-92e3-b8aacea4bf20')
                                @role('super-admin|Consultant')
                                @if(Cookie::get('sentry'))
                                    <livewire:dealer.scan.internal-report-generator :store="$store"/>
                                @else
                                    <div class="max-w-md mx-auto">
                                        <livewire:dealer.scan.login :store="$store"/>
                                    </div>
                                @endif
                                @endrole
                            @endif
                            <livewire:dealer.scan.internal-report-index :store="$store"/>
                        </section>

                        <section
                            x-show="isSelected($id('tab', whichChild($el, $el.parentElement)))"
                            :aria-labelledby="$id('tab', whichChild($el, $el.parentElement))"
                            role="tabpanel"
                            class="p-8"
                        >
                            <livewire:dealer.store.single-store.scan.settings :store="$store"/>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
