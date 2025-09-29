<div>
    <x-slot name="header">
        <x-slot name="pageTitle">Settings</x-slot>
    </x-slot>
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
                >General</button>
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
                    aria-current="page">Phishing</button>
            </div>
        </div>
        <div role="tabpanels" class="mt-5">
            <section
                x-show="isSelected($id('tab', whichChild($el, $el.parentElement)))"
                :aria-labelledby="$id('tab', whichChild($el, $el.parentElement))"
                role="tabpanel"
                class="p-2"
            >
                <div class="max-w-4xl mx-auto">
                    <div class="bg-white p-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Store Course Notifications</h2>
                        <p class="text-sm text-gray-600 mb-6">Enable or disable notifications for courses not taken for each store.</p>

                        <div class="divide-y divide-gray-200">
                            @forelse($stores as $store)
                                <div class="py-4 flex items-center justify-between">
                                    <div class="flex items-center">
                                        <span class="text-sm font-medium text-gray-900">{{ $store->name }}</span>
                                    </div>
                                    <div>
                                        <button
                                            type="button"
                                            wire:click="toggleStoreNotifications({{ $store->id }})"
                                            class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2 {{ $store->courses_not_taken_notification ? 'bg-arm-blue-600' : 'bg-gray-200' }}"
                                            role="switch"
                                            aria-checked="{{ $store->courses_not_taken_notification ? 'true' : 'false' }}"
                                        >
                                            <span
                                                aria-hidden="true"
                                                class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $store->courses_not_taken_notification ? 'translate-x-5' : 'translate-x-0' }}"
                                            ></span>
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <div class="py-4 text-center text-sm text-gray-500">
                                    No stores found.
                                </div>
                            @endforelse
                        </div>
                    </div>
                    <div class="bg-white p-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Audit Remediations</h2>
                        <p class="text-sm text-gray-600 mb-6">Enable or disable the ability to remediate audits for each store.</p>

                        <div class="divide-y divide-gray-200">
                            @forelse($stores as $store)
                                <div class="py-4 flex items-center justify-between">
                                    <div class="flex items-center">
                                        <span class="text-sm font-medium text-gray-900">{{ $store->name }}</span>
                                    </div>
                                    <div>
                                        <button
                                            type="button"
                                            wire:click="toggleRemediations({{ $store->id }})"
                                            class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2 {{ $store->remediationSettings->active ?? false ? 'bg-arm-blue-600' : 'bg-gray-200' }}"
                                            role="switch"
                                            aria-checked="{{ $store->remediationSettings->active ?? false ? 'true' : 'false' }}"
                                        >
                                            <span
                                                aria-hidden="true"
                                                class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $store->remediationSettings->active ?? false ?  'translate-x-5' : 'translate-x-0' }}"
                                            ></span>
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <div class="py-4 text-center text-sm text-gray-500">
                                    No stores found.
                                </div>
                            @endforelse
                        </div>
                    </div>
                    @can('create-dealerships')
                    <div class="bg-white p-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Reset Courses</h2>
                        <p class="text-sm text-gray-600 mb-6">Doing this will reset courses for all employees throughout all dealerships.</p>
                        <livewire:dealer.course.reset />
                    </div>
                    @endcan
                </div>
            </section>
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
                    <div class="max-w-4xl mx-auto">
                        <form wire:submit.prevent="update"><div>
                                <div class="pt-5">
                                    <div class="flex items-start mb-6">
                                        <div class="flex items-center h-5">
                                            <input wire:model="phishing_active"
                                                   id="phishing-active"
                                                   type="checkbox" class="hidden peer">
                                            <label for="phishing-active"
                                                   class="peer-checked:[&_svg]:scale-100 text-sm font-medium text-neutral-600 peer-checked:text-arm-blue-600 [&_svg]:scale-0 peer-checked:[&_.phishing-sim]:border-arm-blue-500 peer-checked:[&_.phishing-sim]:bg-arm-blue-500 select-none flex items-center space-x-2">
                                                <span
                                                    class="flex items-center justify-center w-5 h-5 border-2 rounded phishing-sim text-neutral-900">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                         stroke-width="3"
                                                         stroke="currentColor" class="w-3 h-3 text-white duration-300 ease-out">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                                  </svg>
                                                </span>
                                                <span>Phishing Simulations</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="flex gap-5">
                                        <div class="w-full">
                                            <x-input-label for="phishing_token" :value="__('Token')"/>
                                            <x-text-input wire:model.defer="phishing_token" id="phishing_token" class="block mt-1 w-full" type="text"
                                                          :value="old('phishing_token')"
                                                          autofocus/>
                                            <x-input-error :messages="$errors->get('phishing_token')" class="mt-2"/>
                                        </div>
                                        <div class="w-full">
                                            <x-input-label for="phishing_ip" :value="__('IP Address')"/>
                                            <x-text-input wire:model.defer="phishing_ip" id="phishing_ip" class="block mt-1 w-full" type="text"
                                                          :value="old('phishing_ip')"
                                                          autofocus/>
                                            <x-input-error :messages="$errors->get('phishing_ip')" class="mt-2"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="py-3 text-right">
                                    <x-primary-button wire:loading.attr="disabled">Update</x-primary-button>
                                </div>
                            </div>
                        </form>
                    </div>
                </section>
        </div>
    </div>
</div>
