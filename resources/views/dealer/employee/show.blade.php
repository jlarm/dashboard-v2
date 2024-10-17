<x-dealer-app>
    <div class="grid md:grid-cols-4 gap-10 p-5">
        <div class="col-span-1">
            <livewire:dealer.employee.details :user="$user"/>
            <livewire:dealer.employee.dot-cert :user="$user" />
            <livewire:dealer.employee.cert-index :user="$user"/>
        </div>
        <div class="col-span-3">

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
                class="w-full"
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
                            class="inline-flex px-5 py-2.5 border-transparent"
                            role="tab"
                        >Courses</button>
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
                            class="inline-flex px-5 py-2.5 border-transparent"
                            role="tab"
                        >Additional Courses</button>
                    </li>
                    @endcan
                </ul>

                <!-- Panels -->
                <div role="tabpanels" class="border-t border-gray-200 bg-white">
                    <!-- Panel -->
                    <section
                        x-show="isSelected($id('tab', whichChild($el, $el.parentElement)))"
                        :aria-labelledby="$id('tab', whichChild($el, $el.parentElement))"
                        role="tabpanel"
                        class="p-4"
                    >
                        @if($user->department)
                            <livewire:dealer.employee.course-results :user="$user"/>
                        @endif
                    </section>
                    @can('create-dealerships')
                    <section
                        x-show="isSelected($id('tab', whichChild($el, $el.parentElement)))"
                        :aria-labelledby="$id('tab', whichChild($el, $el.parentElement))"
                        role="tabpanel"
                        class="p-4"
                    >
                        @if($user->department)
                            @can('create-dealerships')
                                <livewire:dealer.employee.assign-custom-courses-form :user="$user" />
                            @endcan
                        @endif
                    </section>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</x-dealer-app>
