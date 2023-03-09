<div>

    <div class="relative z-40 md:hidden" role="dialog" aria-modal="true">

        <div class="fixed inset-0 bg-gray-600 bg-opacity-75"></div>

        <div class="fixed inset-0 z-40 flex">
            <div class="relative flex w-full max-w-xs flex-1 flex-col bg-white pt-5 pb-4">

                <div class="absolute top-0 right-0 -mr-14 p-1">
                    <button type="button"
                            class="flex h-12 w-12 items-center justify-center rounded-full focus:bg-gray-600 focus:outline-none">
                        <!-- Heroicon name: outline/x-mark -->
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
                    <nav class="flex h-full flex-col">
                        <div class="space-y-1">
                            <!-- Current: "bg-arm-blue-50 border-arm-blue-600 text-arm-blue-600", Default: "border-transparent text-gray-600 hover:bg-gray-50 hover:text-gray-900" -->
                            <a
                                href="{{ route('dealer.dashboard') }}"
                                class="{{ (request()->is('dashboard')) ? 'bg-arm-blue-50 text-arm-blue-600 border-arm-blue-600' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} border-transparent group border-l-4 py-2 px-3 flex items-center text-sm font-medium"
                            >
                                <svg
                                    class="{{ request()->is('dashboard') ? 'text-arm-blue-500' : 'text-gray-400 group-hover:text-gray-500' }} mr-3 flex-shrink-0 h-6 w-6"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                                </svg>
                                Home
                            </a>
                            @can('create-stores')
                                @if(tenant('locations'))
                                    <a
                                        href="{{ route('dealer.stores.index') }}"
                                        class="{{ (request()->is('stores')) ? 'bg-arm-blue-50 text-arm-blue-600 border-arm-blue-600' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} border-transparent group border-l-4 py-2 px-3 flex items-center text-sm font-medium"
                                    >
                                        <svg
                                            class="{{ request()->is('stores') ? 'text-arm-blue-500' : 'text-gray-400 group-hover:text-gray-500' }} mr-3 flex-shrink-0 h-6 w-6"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/>
                                        </svg>
                                        Stores
                                    </a>
                                @endif
                            @endcan
                            @can('edit-users')
                                <a
                                    href="{{ route('dealer.employees.index') }}"
                                    class="{{ (request()->is('employees')) ? 'bg-arm-blue-50 text-arm-blue-600 border-arm-blue-600' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} border-transparent group border-l-4 py-2 px-3 flex items-center text-sm font-medium"
                                >
                                    <svg
                                        class="{{ request()->is('employees') ? 'text-arm-blue-500' : 'text-gray-400 group-hover:text-gray-500' }} mr-3 flex-shrink-0 h-6 w-6"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                                    </svg>
                                    Employees
                                </a>
                                <a
                                    href="{{ route('dealer.vendor.index') }}"
                                    class="{{ (request()->is('vendors')) ? 'bg-arm-blue-50 text-arm-blue-600 border-arm-blue-600' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} border-transparent group border-l-4 py-2 px-3 flex items-center text-sm font-medium"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5"
                                         class="{{ request()->is('vendors') ? 'text-arm-blue-500' : 'text-gray-400 group-hover:text-gray-500' }} mr-3 flex-shrink-0 h-6 w-6"
                                         stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M14.25 6.087c0-.355.186-.676.401-.959.221-.29.349-.634.349-1.003 0-1.036-1.007-1.875-2.25-1.875s-2.25.84-2.25 1.875c0 .369.128.713.349 1.003.215.283.401.604.401.959v0a.64.64 0 01-.657.643 48.39 48.39 0 01-4.163-.3c.186 1.613.293 3.25.315 4.907a.656.656 0 01-.658.663v0c-.355 0-.676-.186-.959-.401a1.647 1.647 0 00-1.003-.349c-1.036 0-1.875 1.007-1.875 2.25s.84 2.25 1.875 2.25c.369 0 .713-.128 1.003-.349.283-.215.604-.401.959-.401v0c.31 0 .555.26.532.57a48.039 48.039 0 01-.642 5.056c1.518.19 3.058.309 4.616.354a.64.64 0 00.657-.643v0c0-.355-.186-.676-.401-.959a1.647 1.647 0 01-.349-1.003c0-1.035 1.008-1.875 2.25-1.875 1.243 0 2.25.84 2.25 1.875 0 .369-.128.713-.349 1.003-.215.283-.4.604-.4.959v0c0 .333.277.599.61.58a48.1 48.1 0 005.427-.63 48.05 48.05 0 00.582-4.717.532.532 0 00-.533-.57v0c-.355 0-.676.186-.959.401-.29.221-.634.349-1.003.349-1.035 0-1.875-1.007-1.875-2.25s.84-2.25 1.875-2.25c.37 0 .713.128 1.003.349.283.215.604.401.96.401v0a.656.656 0 00.658-.663 48.422 48.422 0 00-.37-5.36c-1.886.342-3.81.574-5.766.689a.578.578 0 01-.61-.58v0z"/>
                                    </svg>


                                    Vendors
                                </a>
                                <a
                                    href="{{ route('dealer.scan.index') }}"
                                    class="{{ (request()->is('scans')) ? 'bg-arm-blue-50 text-arm-blue-600 border-arm-blue-600' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} border-transparent group border-l-4 py-2 px-3 flex items-center text-sm font-medium"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5"
                                         class="{{ request()->is('scans') ? 'text-arm-blue-500' : 'text-gray-400 group-hover:text-gray-500' }} mr-3 flex-shrink-0 h-6 w-6"
                                         stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M12 9v3.75m0-10.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.75c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.75h-.152c-3.196 0-6.1-1.249-8.25-3.286zm0 13.036h.008v.008H12v-.008z"/>
                                    </svg>

                                    Scans
                                </a>
                                <a
                                    href="{{ route('dealer.manual.index') }}"
                                    class="{{ (request()->is('manuals')) ? 'bg-arm-blue-50 text-arm-blue-600 border-arm-blue-600' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} border-transparent group border-l-4 py-2 px-3 flex items-center text-sm font-medium"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5"
                                         class="{{ request()->is('manuals') ? 'text-arm-blue-500' : 'text-gray-400 group-hover:text-gray-500' }} mr-3 flex-shrink-0 h-6 w-6"
                                         stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                                    </svg>
                                    Manuals
                                </a>
                            @endcan
                            <a
                                href="{{ route('dealer.courses.index') }}"
                                class="{{ (request()->is('courses')) ? 'bg-arm-blue-50 text-arm-blue-600 border-arm-blue-600' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} border-transparent group border-l-4 py-2 px-3 flex items-center text-sm font-medium"
                            >
                                <svg
                                    class="{{ request()->is('courses') ? 'text-arm-blue-500' : 'text-gray-400 group-hover:text-gray-500' }} mr-3 flex-shrink-0 h-6 w-6"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5"/>
                                </svg>
                                Courses
                            </a>
                        </div>
                        <div class="mt-auto space-y-1 pt-10">
                            {{--                            <a href="#"--}}
                            {{--                               class="group flex items-center border-l-4 border-transparent py-2 px-3 text-base font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900">--}}
                            {{--                                <!-- Heroicon name: outline/question-mark-circle -->--}}
                            {{--                                <svg class="mr-4 h-6 w-6 text-gray-400 group-hover:text-gray-500"--}}
                            {{--                                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"--}}
                            {{--                                     stroke-width="1.5" stroke="currentColor" aria-hidden="true">--}}
                            {{--                                    <path stroke-linecap="round" stroke-linejoin="round"--}}
                            {{--                                          d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z"/>--}}
                            {{--                                </svg>--}}
                            {{--                                Help--}}
                            {{--                            </a>--}}

                            <form method="POST" action="{{ route('dealer.logout') }}">
                                @csrf
                                <a href="#"
                                   onclick="event.preventDefault(); this.closest('form').submit();"
                                   class="group flex items-center border-l-4 border-transparent py-2 px-3 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                                    <!-- Heroicon name: outline/arrow-left-on-rectangle -->
                                    <svg class="mr-3 h-6 w-6 text-gray-400 group-hover:text-gray-500"
                                         xmlns="http://www.w3.org/2000/svg"
                                         fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                         aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/>
                                    </svg>
                                    Logout
                                </a>
                            </form>
                        </div>
                    </nav>
                </div>
            </div>

            <div class="w-14 flex-shrink-0" aria-hidden="true">
                <!-- Dummy element to force sidebar to shrink to fit close icon -->
            </div>
        </div>
    </div>

    <!-- Static sidebar for desktop -->
    <div class="hidden md:fixed md:inset-y-0 md:flex md:w-64 md:flex-col">
        <!-- Sidebar component, swap this element with another sidebar if you like -->
        <nav class="flex flex-grow flex-col overflow-y-auto border-r border-gray-200 bg-gray-50 pt-5 pb-4">
            <div class="flex flex-shrink-0 items-center px-4">
                <x-application-logo class="h-auto w-full"/>
            </div>
            <div class="mt-5 flex-grow">
                <div class="space-y-1">
                    <livewire:dealer.navigation.manager-stores/>
                    @can('create-stores')
                        <a
                            href="{{ route('dealer.dashboard') }}"
                            class="{{ (request()->is('dashboard')) ? 'bg-arm-blue-50 text-arm-blue-600 border-arm-blue-600' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} border-transparent group border-l-4 py-2 px-3 flex items-center text-sm font-medium"
                        >
                            <svg
                                class="{{ request()->is('dashboard') ? 'text-arm-blue-500' : 'text-gray-400 group-hover:text-gray-500' }} mr-3 flex-shrink-0 h-6 w-6"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                            </svg>
                            Home
                        </a>
                        @can('create-stores')
                            @if(tenant('locations'))
                                <a
                                    href="{{ route('dealer.stores.index') }}"
                                    class="{{ (request()->is('stores')) ? 'bg-arm-blue-50 text-arm-blue-600 border-arm-blue-600' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} border-transparent group border-l-4 py-2 px-3 flex items-center text-sm font-medium"
                                >
                                    <svg
                                        class="{{ request()->is('stores') ? 'text-arm-blue-500' : 'text-gray-400 group-hover:text-gray-500' }} mr-3 flex-shrink-0 h-6 w-6"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/>
                                    </svg>
                                    Stores
                                </a>
                            @endif
                        @endcan
                        @can('edit-users')
                            <a
                                href="{{ route('dealer.employees.index') }}"
                                class="{{ (request()->is('employees')) ? 'bg-arm-blue-50 text-arm-blue-600 border-arm-blue-600' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} border-transparent group border-l-4 py-2 px-3 flex items-center text-sm font-medium"
                            >
                                <svg
                                    class="{{ request()->is('employees') ? 'text-arm-blue-500' : 'text-gray-400 group-hover:text-gray-500' }} mr-3 flex-shrink-0 h-6 w-6"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                                </svg>
                                Employees
                            </a>
                            <a
                                href="{{ route('dealer.vendor.index') }}"
                                class="{{ (request()->is('vendors')) ? 'bg-arm-blue-50 text-arm-blue-600 border-arm-blue-600' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} border-transparent group border-l-4 py-2 px-3 flex items-center text-sm font-medium"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5"
                                     class="{{ request()->is('vendors') ? 'text-arm-blue-500' : 'text-gray-400 group-hover:text-gray-500' }} mr-3 flex-shrink-0 h-6 w-6"
                                     stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M14.25 6.087c0-.355.186-.676.401-.959.221-.29.349-.634.349-1.003 0-1.036-1.007-1.875-2.25-1.875s-2.25.84-2.25 1.875c0 .369.128.713.349 1.003.215.283.401.604.401.959v0a.64.64 0 01-.657.643 48.39 48.39 0 01-4.163-.3c.186 1.613.293 3.25.315 4.907a.656.656 0 01-.658.663v0c-.355 0-.676-.186-.959-.401a1.647 1.647 0 00-1.003-.349c-1.036 0-1.875 1.007-1.875 2.25s.84 2.25 1.875 2.25c.369 0 .713-.128 1.003-.349.283-.215.604-.401.959-.401v0c.31 0 .555.26.532.57a48.039 48.039 0 01-.642 5.056c1.518.19 3.058.309 4.616.354a.64.64 0 00.657-.643v0c0-.355-.186-.676-.401-.959a1.647 1.647 0 01-.349-1.003c0-1.035 1.008-1.875 2.25-1.875 1.243 0 2.25.84 2.25 1.875 0 .369-.128.713-.349 1.003-.215.283-.4.604-.4.959v0c0 .333.277.599.61.58a48.1 48.1 0 005.427-.63 48.05 48.05 0 00.582-4.717.532.532 0 00-.533-.57v0c-.355 0-.676.186-.959.401-.29.221-.634.349-1.003.349-1.035 0-1.875-1.007-1.875-2.25s.84-2.25 1.875-2.25c.37 0 .713.128 1.003.349.283.215.604.401.96.401v0a.656.656 0 00.658-.663 48.422 48.422 0 00-.37-5.36c-1.886.342-3.81.574-5.766.689a.578.578 0 01-.61-.58v0z"/>
                                </svg>


                                Vendors
                            </a>
                            <a
                                href="{{ route('dealer.scan.index') }}"
                                class="{{ (request()->is('scans')) ? 'bg-arm-blue-50 text-arm-blue-600 border-arm-blue-600' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} border-transparent group border-l-4 py-2 px-3 flex items-center text-sm font-medium"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5"
                                     class="{{ request()->is('scans') ? 'text-arm-blue-500' : 'text-gray-400 group-hover:text-gray-500' }} mr-3 flex-shrink-0 h-6 w-6"
                                     stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M12 9v3.75m0-10.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.75c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.75h-.152c-3.196 0-6.1-1.249-8.25-3.286zm0 13.036h.008v.008H12v-.008z"/>
                                </svg>

                                Scans
                            </a>
                            <a
                                href="{{ route('dealer.manual.index') }}"
                                class="{{ (request()->is('manuals')) ? 'bg-arm-blue-50 text-arm-blue-600 border-arm-blue-600' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} border-transparent group border-l-4 py-2 px-3 flex items-center text-sm font-medium"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5"
                                     class="{{ request()->is('manuals') ? 'text-arm-blue-500' : 'text-gray-400 group-hover:text-gray-500' }} mr-3 flex-shrink-0 h-6 w-6"
                                     stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                                </svg>
                                Manuals
                            </a>
                        @endcan
                        <a
                            href="{{ route('dealer.courses.index') }}"
                            class="{{ (request()->is('courses')) ? 'bg-arm-blue-50 text-arm-blue-600 border-arm-blue-600' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} border-transparent group border-l-4 py-2 px-3 flex items-center text-sm font-medium"
                        >
                            <svg
                                class="{{ request()->is('courses') ? 'text-arm-blue-500' : 'text-gray-400 group-hover:text-gray-500' }} mr-3 flex-shrink-0 h-6 w-6"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5"/>
                            </svg>
                            Courses
                        </a>

                        {{--                    <a--}}
                        {{--                        href="{{ route('dealer.sds.index') }}"--}}
                        {{--                        class="{{ (request()->is('sds')) ? 'bg-arm-blue-50 text-arm-blue-600 border-arm-blue-600' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} border-transparent group border-l-4 py-2 px-3 flex items-center text-sm font-medium"--}}
                        {{--                    >--}}
                        {{--                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"--}}
                        {{--                             class="{{ request()->is('sds') ? 'text-arm-blue-500' : 'text-gray-400 group-hover:text-gray-500' }} mr-3 flex-shrink-0 h-6 w-6"--}}
                        {{--                             stroke="currentColor">--}}
                        {{--                            <path stroke-linecap="round" stroke-linejoin="round"--}}
                        {{--                                  d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23-.693L5 14.5m14.8.8l1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0112 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5"/>--}}
                        {{--                        </svg>--}}
                        {{--                        SDS--}}
                        {{--                    </a>--}}
                    @endcan
                </div>
            </div>
            <div class="block w-full flex-shrink-0">
                {{--                <a href="#"--}}
                {{--                   class="group flex items-center border-l-4 border-transparent py-2 px-3 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900">--}}
                {{--                    <!-- Heroicon name: outline/question-mark-circle -->--}}
                {{--                    <svg class="mr-3 h-6 w-6 text-gray-400 group-hover:text-gray-500" xmlns="http://www.w3.org/2000/svg"--}}
                {{--                         fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">--}}
                {{--                        <path stroke-linecap="round" stroke-linejoin="round"--}}
                {{--                              d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z"/>--}}
                {{--                    </svg>--}}
                {{--                    Help--}}
                {{--                </a>--}}
                <form method="POST" action="{{ route('dealer.logout') }}">
                    @csrf
                    <a href="#"
                       onclick="event.preventDefault(); this.closest('form').submit();"
                       class="group flex items-center border-l-4 border-transparent py-2 px-3 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                        <!-- Heroicon name: outline/arrow-left-on-rectangle -->
                        <svg class="mr-3 h-6 w-6 text-gray-400 group-hover:text-gray-500"
                             xmlns="http://www.w3.org/2000/svg"
                             fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                             aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/>
                        </svg>
                        Logout
                    </a>
                </form>
            </div>
        </nav>
    </div>
</div>
