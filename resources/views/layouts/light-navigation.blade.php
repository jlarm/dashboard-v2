<div>
    <!-- Mobile Sidebar -->
    <div
        x-show="open"
        x-ref="dialog"
        class="relative z-40 lg:hidden" role="dialog" aria-modal="true">

        <div
            x-show="open"
            x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-600 bg-opacity-75"></div>

        <div class="fixed inset-0 z-40 flex">
            <div
                x-show="open"
                x-transition:enter="transition ease-in-out duration-300 transform"
                x-transition:enter-start="-translate-x-full"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="transition ease-in-out duration-300 transform"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="-translate-x-full"
                @click.away="open = false"
                class="relative flex w-full max-w-xs flex-1 flex-col bg-white pt-5 pb-4">

                <div
                    x-show="open"
                    x-transition:enter="ease-in-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in-out duration-300"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="absolute top-0 right-0 -mr-14 p-1">
                    <button type="button"
                            @click="open = false"
                            class="flex h-12 w-12 items-center justify-center rounded-full focus:bg-gray-600 focus:outline-none">
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        <span class="sr-only">Close sidebar</span>
                    </button>
                </div>

                <div class="flex flex-shrink-0 items-center px-4">
                    <x-application-logo class="h-auto w-full"/>
                </div>
                <div class="mt-5 h-0 flex-1 overflow-y-auto">
                    <div class="my-5 px-4">
                        @if (tenant('locations'))
                            @can('create-users')
                                <livewire:dealer.navigation.store-switcher />
                            @endcan
                        @endif
                    </div>
                    <livewire:dealer.navigation.main />
                </div>
            </div>

            <div class="w-14 flex-shrink-0" aria-hidden="true">
                <!-- Dummy element to force sidebar to shrink to fit close icon -->
            </div>
        </div>
    </div>

    <!-- Static sidebar for desktop -->
    <div class="hidden lg:fixed md:inset-y-0 lg:flex md:w-64 md:flex-col">
        <!-- Sidebar component, swap this element with another sidebar if you like -->
        <nav class="flex flex-grow flex-col overflow-y-auto border-r border-gray-200 bg-white pt-5">
            <div class="flex flex-shrink-0 items-center px-4">
                <x-application-logo class="h-auto w-full"/>
            </div>
            <div class="my-5 px-4">
                @if (tenant('locations'))
                    @can('create-users')
                        <livewire:dealer.navigation.store-switcher />
                    @endcan
                @endif
            </div>
            <livewire:dealer.navigation.main />
        </nav>
    </div>
</div>
