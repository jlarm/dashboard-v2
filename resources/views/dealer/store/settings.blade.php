<x-dealer-app>
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
    >
        <x-slot name="header">
            <x-slot name="pageTitle">Settings</x-slot>
        </x-slot>
        <div class="flex justify-center">
            <div
                class="inline-flex h-10 rounded-lg bg-gray-800/5 p-1"
                x-ref="tablist"
                @keydown.right.prevent.stop="$focus.wrap().next()"
                @keydown.home.prevent.stop="$focus.first()"
                @keydown.page-up.prevent.stop="$focus.first()"
                @keydown.left.prevent.stop="$focus.wrap().prev()"
                @keydown.end.prevent.stop="$focus.last()"
                @keydown.page-down.prevent.stop="$focus.last()"
                role="tablist"
            >
                <button
                    :id="$id('tab', whichChild($el, $el.parentElement))"
                    @click="select($el.id)"
                    @mousedown.prevent
                    @focus="select($el.id)"
                    type="button"
                    :tabindex="isSelected($el.id) ? 0 : -1"
                    :aria-selected="isSelected($el.id)"
                    :class="isSelected($el.id) ? 'shadow-sm bg-white text-gray-600' : 'border-transparent'"
                    class="flex whitespace-nowrap flex-1 justify-center items-center rounded-md text-sm text-gray-600 hover:text-gray-800 px-4 border-transparent"
                    aria-current="page">General</button>
                <button
                    :id="$id('tab', whichChild($el, $el.parentElement))"
                    @click="select($el.id)"
                    @mousedown.prevent
                    @focus="select($el.id)"
                    type="button"
                    :tabindex="isSelected($el.id) ? 0 : -1"
                    :aria-selected="isSelected($el.id)"
                    :class="isSelected($el.id) ? 'shadow-sm bg-white text-gray-600' : 'border-transparent'"
                    class="flex whitespace-nowrap flex-1 justify-center items-center rounded-md text-sm text-gray-600 hover:text-gray-800 px-4 border-transparent"
                >Managers</button>
                <button
                    :id="$id('tab', whichChild($el, $el.parentElement))"
                    @click="select($el.id)"
                    @mousedown.prevent
                    @focus="select($el.id)"
                    type="button"
                    :tabindex="isSelected($el.id) ? 0 : -1"
                    :aria-selected="isSelected($el.id)"
                    :class="isSelected($el.id) ? 'shadow-sm bg-white text-gray-600' : 'border-transparent'"
                    class="flex whitespace-nowrap flex-1 justify-center items-center rounded-md text-sm text-gray-600 hover:text-gray-800 px-4 border-transparent"
                >Compliance</button>
                @can('create-dealerships')
                <button
                    :id="$id('tab', whichChild($el, $el.parentElement))"
                    @click="select($el.id)"
                    @mousedown.prevent
                    @focus="select($el.id)"
                    type="button"
                    :tabindex="isSelected($el.id) ? 0 : -1"
                    :aria-selected="isSelected($el.id)"
                    :class="isSelected($el.id) ? 'shadow-sm bg-white text-gray-600' : 'border-transparent'"
                    class="flex whitespace-nowrap flex-1 justify-center items-center rounded-md text-sm text-gray-600 hover:text-gray-800 px-4 border-transparent"
                >Course Management</button>
                @endcan
                <button
                    :id="$id('tab', whichChild($el, $el.parentElement))"
                    @click="select($el.id)"
                    @mousedown.prevent
                    @focus="select($el.id)"
                    type="button"
                    :tabindex="isSelected($el.id) ? 0 : -1"
                    :aria-selected="isSelected($el.id)"
                    :class="isSelected($el.id) ? 'shadow-sm bg-white text-gray-600' : 'border-transparent'"
                    class="flex whitespace-nowrap flex-1 justify-center items-center rounded-md text-sm text-gray-600 hover:text-gray-800 px-4 border-transparent"
                >Ridgeback</button>
            </div>
        </div>
        <div role="tabpanels" class="mt-5">
            <!-- Panel -->
            <section
                x-show="isSelected($id('tab', whichChild($el, $el.parentElement)))"
                :aria-labelledby="$id('tab', whichChild($el, $el.parentElement))"
                role="tabpanel"
                class="p-2"
            >
                <livewire:dealer.store.single-store-details :store="$store"/>
            </section>

            <section
                x-show="isSelected($id('tab', whichChild($el, $el.parentElement)))"
                :aria-labelledby="$id('tab', whichChild($el, $el.parentElement))"
                role="tabpanel"
                class="p-2"
            >
                <livewire:dealer.settings.employee-list :store="$store"/>
            </section>

            <section
                x-show="isSelected($id('tab', whichChild($el, $el.parentElement)))"
                :aria-labelledby="$id('tab', whichChild($el, $el.parentElement))"
                role="tabpanel"
                class="p-2"
            >
                <livewire:dealer.store.single-onboarding-details :store="$store"/>
            </section>
            @can('create-dealerships')
            <section
                x-show="isSelected($id('tab', whichChild($el, $el.parentElement)))"
                :aria-labelledby="$id('tab', whichChild($el, $el.parentElement))"
                role="tabpanel"
                class="p-2"
            >
                <livewire:dealer.settings.optional-courses-form />
            </section>
                <section
                    x-show="isSelected($id('tab', whichChild($el, $el.parentElement)))"
                    :aria-labelledby="$id('tab', whichChild($el, $el.parentElement))"
                    role="tabpanel"
                    class="p-2"
                >
                    <livewire:dealer.settings.ridgeback-settings-form :store="$store" />
                </section>
            @endcan
        </div>
    </div>
</x-dealer-app>
