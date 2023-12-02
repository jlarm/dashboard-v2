<div>
    <!-- HOME -->
    <a
        href="{{ $currentStore ? route('dealer.stores.home', $currentStore) : route('dealer.dashboard') }}"
        class="{{ (request()->routeIs('dealer.dashboard') || request()->routeIs('dealer.stores.home')) ? 'bg-arm-blue-50 text-arm-blue-600 border-arm-blue-600' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} border-transparent group border-l-4 py-2 px-3 flex items-center text-sm font-medium"
    >
        <svg
            class="{{ (request()->routeIs('dealer.dashboard') || request()->routeIs('dealer.stores.home')) ? 'text-arm-blue-500' : 'text-gray-400 group-hover:text-gray-500' }} mr-3 flex-shrink-0 h-6 w-6"
            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
        </svg>
        {{ __('Home') }}
    </a>
    <!-- EMPLOYEES -->
    @can('create-users')
        <a
            href="{{ $currentStore ? route('dealer.stores.employees', $currentStore) : route('dealer.employees.index') }}"
            class="{{ (request()->routeIs('dealer.stores.employees') || request()->routeIs('dealer.employees.index')) || request()->routeIs('dealer.employees.show') || request()->routeIs('dealer.stores.employees.show') ? 'bg-arm-blue-50 text-arm-blue-600 border-arm-blue-600' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} border-transparent group border-l-4 py-2 px-3 flex items-center text-sm font-medium"
        >
            <svg
                class="{{ (request()->routeIs('dealer.stores.employees') || request()->routeIs('dealer.employees.index')) || request()->routeIs('dealer.employees.show') || request()->routeIs('dealer.stores.employees.show') ? 'text-arm-blue-500' : 'text-gray-400 group-hover:text-gray-500' }} mr-3 flex-shrink-0 h-6 w-6"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
            </svg>
            Employees
        </a>
    @endcan
    <!-- SCANS -->
    @can('view-scans')
        @if (request()->segment(1) === 'stores' || !tenant('locations'))
        <a
            href="{{ $currentStore ? route('dealer.stores.scans', $currentStore) : route('dealer.scan.index') }}"
            class="{{ (request()->routeIs('dealer.scan.index') || request()->routeIs('dealer.stores.scans')) ? 'bg-arm-blue-50 text-arm-blue-600 border-arm-blue-600' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} border-transparent group border-l-4 py-2 px-3 flex items-center text-sm font-medium"
        >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                 stroke-width="1.5"
                 class="{{ (request()->routeIs('dealer.scan.index') || request()->routeIs('dealer.stores.scans')) ? 'text-arm-blue-500' : 'text-gray-400 group-hover:text-gray-500' }} mr-3 flex-shrink-0 h-6 w-6"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 9v3.75m0-10.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.75c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.75h-.152c-3.196 0-6.1-1.249-8.25-3.286zm0 13.036h.008v.008H12v-.008z"/>
            </svg>

            IT Scans
        </a>
        @endif
    @endcan
    <!-- MANUALS -->
    @can('create-stores')
        @if (request()->segment(1) === 'stores' || !tenant('locations'))
        <a
            href="{{ $currentStore ? route('dealer.stores.manuals', $currentStore) : route('dealer.manual.index') }}"
            class="{{ (request()->routeIs('dealer.manual.index') || request()->routeIs('dealer.stores.manuals')) ? 'bg-arm-blue-50 text-arm-blue-600 border-arm-blue-600' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} border-transparent group border-l-4 py-2 px-3 flex items-center text-sm font-medium"
        >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                 stroke-width="1.5"
                 class="{{ (request()->routeIs('dealer.manual.index') || request()->routeIs('dealer.stores.manuals')) ? 'text-arm-blue-500' : 'text-gray-400 group-hover:text-gray-500' }} mr-3 flex-shrink-0 h-6 w-6"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
            </svg>
            Manuals
        </a>
        @endif
    @endcan
    <!-- AUDITS -->
    @can('view-audits')
        @if (request()->segment(1) === 'stores' || !tenant('locations'))
        <div
            x-data="{ open: '{{ request()->segment(1) == 'audits' || request()->segment(3) === 'audits' }}' }"
        >
            <button
                class="{{ (request()->segment(1) == 'audits' || request()->segment(3) === 'audits') ? 'bg-arm-blue-50 text-arm-blue-600 border-arm-blue-600' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} w-full border-transparent group border-l-4 py-2 px-3 flex text-sm font-medium"
                type="button"
                @click="open = !open"
            >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke-width="1.5" stroke="currentColor"
                     class="{{ (request()->segment(1) == 'audits' || request()->segment(3) === 'audits') ? 'text-arm-blue-500' : 'text-gray-400 group-hover:text-gray-500' }} mr-3 flex-shrink-0 h-6 w-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                </svg>
                Audits
                <svg
                    class="text-gray-400 ml-auto h-5 w-5 shrink-0"
                    :class="{ 'rotate-90 text-gray-500': open, 'text-gray-400': !(open) }"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                    aria-hidden="true">
                    <path fill-rule="evenodd"
                          d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                          clip-rule="evenodd"/>
                </svg>
            </button>
            <ul
                x-cloak
                class="block w-full mt-1 px-2"
                id="sub-menu-1"
                x-show="open"
                x-collapse
            >
                <li>
                    <a href="{{ $currentStore ? route('dealer.stores.audits.osha.index', $currentStore) : route('dealer.audit.osha.index') }}"
                       class="{{ (request()->segment(2) == 'osha' || request()->segment(4) === 'osha') ? 'bg-arm-blue-50 active' : '' }} hover:bg-gray-50 block rounded-md py-2 pr-2 pl-11 text-sm leading-6 text-gray-700">OSHA</a>
                </li>
                <li>
                    <a href="{{ $currentStore ? route('dealer.stores.audits.body-shop.index', $currentStore) : route('dealer.audit.body-shop.index') }}"
                       class="{{ (request()->segment(2) == 'body-shop' || request()->segment(4) === 'body-shop') ? 'bg-arm-blue-50' : '' }} hover:bg-gray-50 block rounded-md py-2 pr-2 pl-11 text-sm leading-6 text-gray-700">Body
                        Shop</a>
                </li>
                <li>
                    <a href="{{ $currentStore ? route('dealer.stores.audits.finance.index', $currentStore) : route('dealer.audit.finance.index') }}"
                       class="{{ (request()->segment(2) == 'finance' || request()->segment(4) === 'finance') ? 'bg-arm-blue-50' : '' }} hover:bg-gray-50 block rounded-md py-2 pr-2 pl-11 text-sm leading-6 text-gray-700">GLBA
                        Walkthrough</a>
                </li>
                <li>
                    <a href="{{ $currentStore ? route('dealer.stores.audits.individual.index', $currentStore) : route('dealer.audit.individual.index') }}"
                       class="{{ (request()->segment(2) == 'deal-jackets' || request()->segment(4) === 'deal-jackets') ? 'bg-arm-blue-50' : '' }} hover:bg-gray-50 block rounded-md py-2 pr-2 pl-11 text-sm leading-6 text-gray-700">Deal
                        Jackets</a>
                </li>
            </ul>
        </div>
        @endif
    @endcan
    <!-- VENDORS -->
    @can('view-vendors')
        <a
            href="{{ $currentStore ? route('dealer.stores.vendors.index', $currentStore) : route('dealer.vendor.index') }}"
            class="{{ (request()->routeIs('dealer.vendor.index') || request()->routeIs('dealer.stores.vendors.index')) ? 'bg-arm-blue-50 text-arm-blue-600 border-arm-blue-600' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} border-transparent group border-l-4 py-2 px-3 flex items-center text-sm font-medium"
        >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                 stroke-width="1.5"
                 class="{{ (request()->routeIs('dealer.vendor.index') || request()->routeIs('dealer.stores.vendors.index')) ? 'text-arm-blue-500' : 'text-gray-400 group-hover:text-gray-500' }} mr-3 flex-shrink-0 h-6 w-6"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M14.25 6.087c0-.355.186-.676.401-.959.221-.29.349-.634.349-1.003 0-1.036-1.007-1.875-2.25-1.875s-2.25.84-2.25 1.875c0 .369.128.713.349 1.003.215.283.401.604.401.959v0a.64.64 0 01-.657.643 48.39 48.39 0 01-4.163-.3c.186 1.613.293 3.25.315 4.907a.656.656 0 01-.658.663v0c-.355 0-.676-.186-.959-.401a1.647 1.647 0 00-1.003-.349c-1.036 0-1.875 1.007-1.875 2.25s.84 2.25 1.875 2.25c.369 0 .713-.128 1.003-.349.283-.215.604-.401.959-.401v0c.31 0 .555.26.532.57a48.039 48.039 0 01-.642 5.056c1.518.19 3.058.309 4.616.354a.64.64 0 00.657-.643v0c0-.355-.186-.676-.401-.959a1.647 1.647 0 01-.349-1.003c0-1.035 1.008-1.875 2.25-1.875 1.243 0 2.25.84 2.25 1.875 0 .369-.128.713-.349 1.003-.215.283-.4.604-.4.959v0c0 .333.277.599.61.58a48.1 48.1 0 005.427-.63 48.05 48.05 0 00.582-4.717.532.532 0 00-.533-.57v0c-.355 0-.676.186-.959.401-.29.221-.634.349-1.003.349-1.035 0-1.875-1.007-1.875-2.25s.84-2.25 1.875-2.25c.37 0 .713.128 1.003.349.283.215.604.401.96.401v0a.656.656 0 00.658-.663 48.422 48.422 0 00-.37-5.36c-1.886.342-3.81.574-5.766.689a.578.578 0 01-.61-.58v0z"/>
            </svg>
            Vendors
        </a>
    @endcan
    <!-- DOCS -->
    @can('view-manuals')
        @if (request()->segment(1) === 'stores' || !tenant('locations'))
        <a
            href="{{ $currentStore ? route('dealer.stores.doc.index', $currentStore) : route('dealer.doc.index') }}"
            class="{{ (request()->routeIs('dealer.doc.index') || request()->routeIs('dealer.stores.doc.index')) ? 'bg-arm-blue-50 text-arm-blue-600 border-arm-blue-600' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} border-transparent group border-l-4 py-2 px-3 flex items-center text-sm font-medium"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="{{ (request()->routeIs('dealer.doc.index') || request()->routeIs('dealer.stores.doc.index')) ? 'text-arm-blue-500' : 'text-gray-400 group-hover:text-gray-500' }} mr-3 flex-shrink-0 h-6 w-6"
            >
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
            </svg>
            Documents
        </a>
        @endif
    @endcan
    <!-- COURSES -->
    @unlessrole('super-admin|Consultant')
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
        {{ __('Courses') }}
    </a>
    @endunlessrole
    <!-- COURSE LIST FOR DEMO -->
    @if(tenant('id') === 'e44653a5-c049-4be0-92e3-b8aacea4bf20')
        <a
            href="{{ route('dealer.courses.all') }}"
            class="{{ (request()->is('courses/all')) ? 'bg-arm-blue-50 text-arm-blue-600 border-arm-blue-600' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} border-transparent group border-l-4 py-2 px-3 flex items-center text-sm font-medium"
        >
            <svg
                class="{{ request()->is('courses/all') ? 'text-arm-blue-500' : 'text-gray-400 group-hover:text-gray-500' }} mr-3 flex-shrink-0 h-6 w-6"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5"/>
            </svg>
            {{ __('Courses') }}
        </a>
    @endif
    <!--  SETTINGS -->
    @can('create-stores')
        @if (request()->segment(1) === 'stores' || !tenant('locations'))
        <a
            href="{{ $currentStore ? route('dealer.stores.settings', $currentStore) : route('dealer.dealer.settings') }}"
            class="{{ (request()->routeIs('dealer.dealer.settings') || request()->routeIs('dealer.stores.settings')) ? 'bg-arm-blue-50 text-arm-blue-600 border-arm-blue-600' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} border-transparent group border-l-4 py-2 px-3 flex items-center text-sm font-medium"
        >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                 stroke-width="1.5"
                 stroke="currentColor"
                 class="{{ (request()->routeIs('dealer.dealer.settings') || request()->routeIs('dealer.stores.settings')) ? 'text-arm-blue-500' : 'text-gray-400 group-hover:text-gray-500' }} mr-3 flex-shrink-0 h-6 w-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"/>
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>

            Settings
        </a>
        @endif
    @endcan

    @if(tenant('locations'))
    @can('create-stores')
    @if (request()->segment(1) === 'stores' || !tenant('locations'))
    <div class="mt-10 border-t">
        <div class="text-xs font-semibold leading-6 text-gray-400 p-4 pb-0">Global Views</div>
        <div>
            <!-- HOME -->
            @can('create-users')
                <a
                    href="{{ route('dashboard') }}"
                    class="{{ (request()->segment(1) == 'dashboard') ? 'bg-arm-blue-50 text-arm-blue-600 border-arm-blue-600' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} border-transparent group border-l-4 py-2 px-3 flex items-center text-xs"
                >
                    Stats Overview
                </a>
            @endcan
            <!-- EMPLOYEES -->
            @can('create-users')
                <a
                    href="{{ route('dealer.employees.index') }}"
                    class="{{ (request()->segment(1) == 'employees') ? 'bg-arm-blue-50 text-arm-blue-600 border-arm-blue-600' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} border-transparent group border-l-4 py-2 px-3 flex items-center text-xs"
                >
                    All Employees
                </a>
            @endcan
            <!-- VENDORS -->
            @can('view-vendors')
                <a
                    href="{{ route('dealer.vendor.index') }}"
                    class="{{ (request()->segment(1) == 'vendors') ? 'bg-arm-blue-50 text-arm-blue-600 border-arm-blue-600' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} border-transparent group border-l-4 py-2 px-3 flex items-center text-xs"
                >
                    All Vendors
                </a>
            @endcan
        </div>
    </div>
    @endif
    @endcan
    @endif
</div>
