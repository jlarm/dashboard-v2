<div class="px-6">
    <div
        class="py-5 sm:flex sm:items-center sm:justify-between">
        <div class="min-w-0 flex-1">
            <h1 class="text-4xl font-bold text-arm-blue-900 sm:truncate leading-normal">Settings</h1>
        </div>
    </div>
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
        class="border rounded-xl border-gray-200 shadow-sm p-6"
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
                >General Information</button>
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
                >Manager Information</button>
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
                >Compliance Information</button>
            </li>
            @can('create-dealerships')
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
                >Ridgeback</button>
            </li>
            @endcan
        </ul>

        <!-- Panels -->
        <div role="tabpanels" class="bg-white border-t">
            <!-- Panel -->
            <section
                x-show="isSelected($id('tab', whichChild($el, $el.parentElement)))"
                :aria-labelledby="$id('tab', whichChild($el, $el.parentElement))"
                role="tabpanel"
                class="p-8"
            >
                <livewire:dealer.store.single-store-details :store="$store"/>
            </section>

            <section
                x-show="isSelected($id('tab', whichChild($el, $el.parentElement)))"
                :aria-labelledby="$id('tab', whichChild($el, $el.parentElement))"
                role="tabpanel"
                class="p-8"
            >
                <livewire:dealer.settings.employee-list :store="$store"/>
            </section>

            <section
                x-show="isSelected($id('tab', whichChild($el, $el.parentElement)))"
                :aria-labelledby="$id('tab', whichChild($el, $el.parentElement))"
                role="tabpanel"
                class="p-8"
            >
                <livewire:dealer.store.single-onboarding-details :store="$store"/>
            </section>
            @can('create-dealerships')
            <section
                x-show="isSelected($id('tab', whichChild($el, $el.parentElement)))"
                :aria-labelledby="$id('tab', whichChild($el, $el.parentElement))"
                role="tabpanel"
                class="p-8"
            >
                <livewire:dealer.settings.ridgeback-settings-form :store="$store"/>
            </section>
            @endcan
        </div>
    </div>
</div>
