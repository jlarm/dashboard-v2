<div>
    <x-slot name="header">
        <x-slot name="pageTitle">
            <div class="flex items-center gap-2">
                {{ $user->name }}
                @if($isQi)
                    <span x-data="{ show: false }" @mouseenter="show = true" @mouseleave="show = false" class="group inline-flex items-center gap-x-0.5 text-xs font-medium text-green-500">
                    <svg class="size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none">
                        <path d="M4.9971 5.0071C4.9971 5.00158 5.00158 4.9971 5.0071 4.9971H8.99876L11.9929 2.00293C11.9968 1.99902 12.0032 1.99902 12.0071 2.00293L15.0012 4.9971H18.9929C18.9984 4.9971 19.0029 5.00158 19.0029 5.0071V8.99876L21.9971 11.9929C22.001 11.9968 22.001 12.0032 21.9971 12.0071L19.0029 15.0012V18.9929C19.0029 18.9984 18.9984 19.0029 18.9929 19.0029H15.0012L12.0071 21.9971C12.0032 22.001 11.9968 22.001 11.9929 21.9971L9.00169 19.0058C8.99981 19.004 8.99727 19.0029 8.99461 19.0029H5.0071C5.00158 19.0029 4.9971 18.9984 4.9971 18.9929V15.0012L2.00293 12.0071C1.99902 12.0032 1.99902 11.9968 2.00293 11.9929L4.9971 8.99876V5.0071Z" stroke="currentColor" stroke-width="1.5" />
                        <path d="M9 12.8929C9 12.8929 10.2 13.5447 10.8 14.5C10.8 14.5 12.6 10.75 15 9.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="square" />
                    </svg>
                    <span x-show="show" x-cloak x-transition.opacity.duration.50ms class="whitespace-nowrap">Qualified Individual</span>
                </span>
            </div>
            @endif
            <ul class="flex flex-wrap items-center gap-x-3 font-normal">
                <li class="relative before:hidden md:before:inline-block first:before:hidden first:before:ms-0 before:content-['•'] before:text-gray-800 before:me-1.5">
                      <span class="text-sm text-gray-800">
                        Department:
                      </span>
                    <span class="inline-flex items-center gap-x-2 text-sm text-gray-500">
                        {{ $user->department->name ?? '' }}
                      </span>
                </li>

                <li class="relative before:hidden md:before:inline-block first:before:hidden first:before:ms-0 before:content-['•'] before:text-gray-800 before:me-1.5">
                      <span class="text-sm text-gray-800">
                        Role:
                      </span>
                    <span class="inline-flex items-center gap-x-2 text-sm text-gray-500">
                        @foreach($roles as $role)
                            {{ $role }}
                        @endforeach
                      </span>
                </li>
            </ul>
            <x-slot name="actions">
                <livewire:dealer.employee.details :user="$user"/>
            </x-slot>
        </x-slot>
    </x-slot>
    <div class="">
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
                <div class="flex justify-center">
                    <div
                        class="inline-flex h-10 rounded-lg bg-gray-800/5 p-1 max-w-[500px]"
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
                            aria-current="page">Courses</button>
                        @hasanyrole('super-admin|Consultant|Qualified Individual')
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
                        >Manage Courses</button>
                        @endhasanyrole
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
                        >DOT Certificates</button>
                    </div>
                </div>

                <!-- Panels -->
                <div role="tabpanels" class="bg-white">
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
                    @hasanyrole('super-admin|Consultant|Qualified Individual')
                        <section
                            x-show="isSelected($id('tab', whichChild($el, $el.parentElement)))"
                            :aria-labelledby="$id('tab', whichChild($el, $el.parentElement))"
                            role="tabpanel"
                            class="p-4"
                        >
                            @if($user->department)
                                <livewire:dealer.employee.assign-custom-courses-form :user="$user" />
                            @endif
                        </section>
                    @endhasanyrole
                    <section
                        x-show="isSelected($id('tab', whichChild($el, $el.parentElement)))"
                        :aria-labelledby="$id('tab', whichChild($el, $el.parentElement))"
                        role="tabpanel"
                        class="p-4"
                    >
                        <div class="col-span-1">
                            <livewire:dealer.employee.dot-cert :user="$user" />
                            <livewire:dealer.employee.cert-index :user="$user"/>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
