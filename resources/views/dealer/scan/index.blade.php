<x-dealer-app>
    <div class="px-6">
        <div
            class="py-5 sm:flex sm:items-center sm:justify-between">
            <div class="min-w-0 flex-1">
                <h1 class="text-4xl font-bold text-arm-blue-900 sm:truncate leading-normal">Scans</h1>
            </div>
        </div>

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
            class="border rounded-xl border-gray-200 shadow-sm p-6"
            x-id="['tab']"
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
                        :class="isSelected($el.id) ? 'border-b border-arm-blue-500 text-arm-blue-500' : 'border-transparent'"
                        class="inline-flex px-5 py-2.5"
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
                        :class="isSelected($el.id) ? 'border-b border-arm-blue-500 text-arm-blue-500' : 'border-transparent'"
                        class="inline-flex px-5 py-2.5"
                        role="tab"
                    >Internal Scans
                    </button>
                </li>
                @if(tenant('id') != 'e44653a5-c049-4be0-92e3-b8aacea4bf20')
                    @can('create-stores')
                    <li>
                        <button
                            :id="$id('tab', whichChild($el.parentElement, $refs.tablist))"
                            @click="select($el.id)"
                            @mousedown.prevent
                            @focus="select($el.id)"
                            type="button"
                            :tabindex="isSelected($el.id) ? 0 : -1"
                            :aria-selected="isSelected($el.id)"
                            :class="isSelected($el.id) ? 'border-b border-arm-blue-500 text-arm-blue-500' : 'border-transparent'"
                            class="inline-flex px-5 py-2.5"
                            role="tab"
                        >Settings
                        </button>
                    </li>
                    @endcan
                @endif
            </ul>

            <!-- Panels -->
            <div role="tabpanels" class="rounded-b-md border-t border-gray-200 bg-white">
                <!-- Panel -->
                <section
                    x-show="isSelected($id('tab', whichChild($el, $el.parentElement)))"
                    :aria-labelledby="$id('tab', whichChild($el, $el.parentElement))"
                    role="tabpanel"
                    class="p-8"
                >
                    <div class="grid grid-cols-1 md:grid-cols-3 md:gap-10">
                        <div class="col-span-2">
                            <livewire:dealer.scan.report-index/>
                        </div>
                        <div class="col-span-1">
                            <livewire:dealer.scan.external-stats />
                        </div>
                    </div>
                </section>

                <section
                    x-show="isSelected($id('tab', whichChild($el, $el.parentElement)))"
                    :aria-labelledby="$id('tab', whichChild($el, $el.parentElement))"
                    role="tabpanel"
                    class="p-8"
                >
                    <div class="grid grid-cols-1 md:grid-cols-3 md:gap-10">
                        <div class="col-span-2">
                            <livewire:dealer.scan.internal-report-index/>
                        </div>
                        <div class="col-span-1">
                            <livewire:dealer.scan.internal-stats />
                        </div>
                    </div>
                </section>
                @can('create-stores')
                <section
                    x-show="isSelected($id('tab', whichChild($el, $el.parentElement)))"
                    :aria-labelledby="$id('tab', whichChild($el, $el.parentElement))"
                    role="tabpanel"
                    class="p-8"
                >
                    <livewire:dealer.scan.settings/>
                </section>
                @endcan
            </div>
        </div>
    </div>
</x-dealer-app>
