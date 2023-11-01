<div
    class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 bg-white px-4 sm:gap-x-6 sm:px-6 lg:px-8"
>
    <button @click="open = true" type="button" class="-m-2.5 p-2.5 text-gray-700 lg:hidden">
        <span class="sr-only">Open sidebar</span>
        <svg
            class="h-6 w-6"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            aria-hidden="true"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"></path>
        </svg>
    </button>

    <!-- Separator -->
    <div class="h-6 w-px bg-gray-900/10 lg:hidden" aria-hidden="true">
    </div>

    <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
        <div class="relative flex flex-1 items-center">
            <h1 class="hidden md:block text-arm-blue-600 font-bold text-2xl">Automotive Risk Management Partners</h1>
            <h1 class="md:hidden text-arm-blue-600 font-bold text-2xl">ARMP</h1>
        </div>
        <div class="flex items-center gap-x-4 lg:gap-x-6">
            {{--            <button--}}
            {{--                type="button"--}}
            {{--                class="-m-2.5 p-2.5 text-gray-400 hover:text-gray-500"--}}
            {{--            >--}}
            {{--                <span class="sr-only">View notifications</span>--}}
            {{--                <svg--}}
            {{--                    class="h-6 w-6"--}}
            {{--                    fill="none"--}}
            {{--                    viewBox="0 0 24 24"--}}
            {{--                    stroke-width="1.5"--}}
            {{--                    stroke="currentColor"--}}
            {{--                    aria-hidden="true"--}}
            {{--                >--}}
            {{--                    <path--}}
            {{--                        stroke-linecap="round"--}}
            {{--                        stroke-linejoin="round"--}}
            {{--                        d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"--}}
            {{--                    ></path>--}}
            {{--                </svg>--}}
            {{--            </button>--}}

            {{--            <!-- Separator -->--}}
            {{--            <div--}}
            {{--                class="hidden lg:block lg:h-6 lg:w-px lg:bg-gray-900/10"--}}
            {{--                aria-hidden="true"--}}
            {{--            >--}}
            {{--            </div>--}}

            <!-- Profile dropdown -->
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button
                        class="inline-flex items-center p-5 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                        <div>{{ Auth::user()->name }}</div>

                        <div class="ml-1">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                      clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-dropdown-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-dropdown-link :href="route('logout')"
                                         onclick="event.preventDefault();
                                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>
    </div>
</div>
