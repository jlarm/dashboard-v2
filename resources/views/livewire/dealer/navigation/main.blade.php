<div>
    <!-- HOME -->
    <div class="px-3 mb-1.5">
        <a
            href="{{ $currentStore ? route('dealer.stores.home', $currentStore) : route('dealer.dashboard') }}"
            class="{{ (request()->routeIs('dealer.dashboard') || request()->routeIs('dealer.stores.home')) ? 'bg-gray-100 text-gray-600' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }} border-transparent group py-2 px-3 rounded-lg flex items-center text-sm"
        >
            <svg class="mr-3 flex-shrink-0 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <path class="{{ (request()->routeIs('dealer.dashboard') || request()->routeIs('dealer.stores.home')) ? 'stroke-gray-600' : 'stroke-gray-400 group-hover:stroke-gray-500' }}" stroke-linejoin="round" stroke-width="1.5" d="M10 2H2v8h8V2ZM22 2h-8v8h8V2ZM10 14H2v8h8v-8ZM22 14h-8v8h8v-8Z"/>
            </svg>
            {{ __('Home') }}
        </a>
    </div>
    <!-- EMPLOYEES -->
    @can('create-users')
        <div class="px-3 mb-1.5">
            <a
                href="{{ $currentStore ? route('dealer.stores.employees', $currentStore) : route('dealer.employees.index') }}"
                class="{{ (request()->segment(1) === 'employees' || request()->segment(3) === 'employees') || request()->routeIs('dealer.employees.show') || request()->routeIs('dealer.stores.employees.show') ? 'bg-gray-100 text-gray-600' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }} border-transparent group py-2 px-3 rounded-lg flex items-center text-sm"
            >
                <svg class="mr-3 flex-shrink-0 h-5 w-5" xmlns="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <path class="{{ (request()->segment(1) === 'employees' || request()->segment(3) === 'employees') || request()->routeIs('dealer.employees.show') || request()->routeIs('dealer.stores.employees.show') ? 'stroke-gray-600' : 'stroke-gray-400 group-hover:stroke-gray-500' }}" stroke-width="1.5" d="M14 10.5a3 3 0 1 0 0-6M2 20.5h14a7 7 0 1 0-14 0ZM18 19.5h3a6 6 0 0 0-6-6M12.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"/>
                </svg>
                Employees
            </a>
        </div>
    @endcan
    <!-- SCANS -->
    @can('create-users')
        <div class="px-3 mb-1.5">
        @if (request()->segment(1) === 'stores' || !tenant('locations'))
        <a
            href="{{ $currentStore ? route('dealer.stores.scan.index', $currentStore) : route('dealer.scan.index') }}"
            class="{{ (request()->segment(1) === 'scans' || request()->segment(3) === 'scans') ? 'bg-gray-100 text-gray-600' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }} border-transparent group py-2 px-3 rounded-lg flex items-center text-sm"
        >
            <svg class="mr-3 flex-shrink-0 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <path class="{{ (request()->segment(1) === 'scans' || request()->segment(3) === 'scans') ? 'stroke-gray-600' : 'stroke-gray-400 group-hover:stroke-gray-500' }}" stroke-linejoin="round" stroke-width="1.5" d="M3 8h18"/>
                <path class="{{ (request()->segment(1) === 'scans' || request()->segment(3) === 'scans') ? 'stroke-gray-600' : 'stroke-gray-400 group-hover:stroke-gray-500' }}" stroke-linecap="square" stroke-linejoin="round" stroke-width="1.5" d="M7 5h.009M11 5h.009"/>
                <path class="{{ (request()->segment(1) === 'scans' || request()->segment(3) === 'scans') ? 'stroke-gray-600' : 'stroke-gray-400 group-hover:stroke-gray-500' }}" stroke-width="1.5" d="M14 16.5V15a2 2 0 1 0-4 0v1.5m-1.5 0h7V22h-7v-5.5Z"/>
                <path class="{{ (request()->segment(1) === 'scans' || request()->segment(3) === 'scans') ? 'stroke-gray-600' : 'stroke-gray-400 group-hover:stroke-gray-500' }}" stroke-width="1.5" d="M6 20H3.01a.01.01 0 0 1-.01-.01V2.01a.01.01 0 0 1 .01-.01h17.98a.01.01 0 0 1 .01.01v17.978a.01.01 0 0 1-.01.01H18"/>
            </svg>
            IT Scans
        </a>
        @endif
        </div>
    @endcan
    <!-- MANUALS -->
    <div class="px-3 mb-1.5">
        @can('create-stores')
            @if (request()->segment(1) === 'stores' || !tenant('locations'))
                <div x-data="{ open: '{{ request()->segment(1) == 'manuals' || request()->segment(3) === 'manuals' }}' }">
                    <button
                        class="{{ (request()->segment(1) == 'manuals' || request()->segment(3) === 'manuals') ? 'bg-gray-100 text-gray-600' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }} w-full border-transparent group py-2 px-3 rounded-lg flex items-center text-sm"
                        type="button"
                        @click="open = !open"
                    >
                        <svg class="mr-3 flex-shrink-0 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path class="{{ (request()->segment(1) === 'manuals' || request()->segment(3) === 'manuals') ? 'stroke-gray-600' : 'stroke-gray-400 group-hover:stroke-gray-500' }}" stroke-width="1.5" d="m9.869 21.988-7.023.01a.01.01 0 0 1-.01-.01V9.001l7.033-6.999h10.036a.01.01 0 0 1 .01.01l-.01 8.986M9.869 2.563V9h-6.47M15.305 21.998h-2.519v-2.472l5.522-5.514a.01.01 0 0 1 .014 0l2.51 2.5a.01.01 0 0 1 0 .013l-5.527 5.473Z"/>
                        </svg>
                        Manuals
                        <svg class="text-gray-400 ml-auto h-5 w-5 shrink-0" :class="{ '-rotate-180 text-gray-500': open, 'text-gray-400': !(open) }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" color="#ffffff" fill="none">
                            <path d="M6 9.00005L12 15L18 9" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="16" />
                        </svg>
                    </button>
                    <ul
                        x-cloak
                        class="x-cloak mt-1 ml-6 border-l-2 border-gray-100 space-y-1"
                        id="sub-menu-1"
                        x-show="open"
                        x-collapse
                    >
                        <li>
                            <a href="{{ $currentStore ? route('dealer.stores.manuals.isp.index', $currentStore) : route('dealer.manual.isp.index') }}"
                               class="{{ (request()->segment(2) == 'isp' || request()->segment(4) === 'isp') ? 'bg-gray-100' : '' }} hover:bg-gray-100 block rounded-lg py-2 px-3 ml-3 text-sm leading-6 text-gray-700">ISP</a>
                        </li>
                        <li>
                            <a href="{{ $currentStore ? route('dealer.stores.manuals.osha.index', $currentStore) : route('dealer.manual.osha.index') }}"
                               class="{{ (request()->segment(1) === 'manuals' && request()->segment(2) == 'osha' || request()->segment(3) === 'manuals' && request()->segment(4) === 'osha') ? 'bg-gray-100' : '' }} hover:bg-gray-100 block rounded-lg py-2 px-3 ml-3 text-sm leading-6 text-gray-700">Osha</a>
                        </li>
                        <li>
                            <a href="{{ $currentStore ? route('dealer.stores.manuals.red-flag.index', $currentStore) : route('dealer.manual.red-flag.index') }}"
                               class="{{ (request()->segment(2) == 'red-flag' || request()->segment(4) === 'red-flag') ? 'bg-gray-100' : '' }} hover:bg-gray-100 block rounded-lg py-2 px-3 ml-3 text-sm leading-6 text-gray-700">Red Flag</a>
                        </li>
                        <li>
                            <a href="{{ $currentStore ? route('dealer.stores.manuals.cms.index', $currentStore) : route('dealer.manual.cms.index') }}"
                               class="{{ (request()->segment(2) == 'cms' || request()->segment(4) === 'cms') ? 'bg-gray-100' : '' }} hover:bg-gray-100 block rounded-lg py-2 px-3 ml-3 text-sm leading-6 text-gray-700">CMS</a>
                        </li>
                    </ul>
                </div>
            @endif
        @endcan
    </div>
    <!-- AUDITS -->
    <div class="px-3 mb-1.5">
        @can('view-audits')
            <div x-data="{ open: '{{ request()->segment(1) == 'audits' || request()->segment(3) === 'audits' }}' }">
                <button
                    class="{{ (request()->segment(1) == 'audits' || request()->segment(3) === 'audits') ? 'bg-gray-100 text-gray-600' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }} w-full border-transparent group py-2 px-3 rounded-lg flex items-center text-sm"
                    type="button"
                    @click="open = !open"
                >
                    <svg class="mr-3 flex-shrink-0 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <path class="{{ (request()->segment(1) == 'audits' || request()->segment(3) === 'audits') ? 'stroke-arm-blue-500' : 'stroke-gray-400 group-hover:stroke-gray-500' }}" stroke-width="1.5" d="M19.007 11.493V2H3v19.985h9.004"/>
                        <path class="{{ (request()->segment(1) == 'audits' || request()->segment(3) === 'audits') ? 'stroke-arm-blue-500' : 'stroke-gray-400 group-hover:stroke-gray-500' }}" stroke-linejoin="round" stroke-width="1.5" d="M7.002 6.996h8.003m-8.003 3.997h4.002"/>
                        <path class="{{ (request()->segment(1) == 'audits' || request()->segment(3) === 'audits') ? 'stroke-arm-blue-500' : 'stroke-gray-400 group-hover:stroke-gray-500' }}" stroke-width="1.5" d="M18.863 19.838a3.371 3.371 0 0 0 1.008-2.442 3.438 3.438 0 0 0-3.44-3.436c-1.9 0-3.44 1.538-3.44 3.436a3.438 3.438 0 0 0 3.44 3.437c.937 0 1.811-.388 2.432-.995Zm0 0 2.136 2.16"/>
                    </svg>
                    Audits
                    <svg class="text-gray-400 ml-auto h-5 w-5 shrink-0" :class="{ '-rotate-180 text-gray-500': open, 'text-gray-400': !(open) }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" color="#ffffff" fill="none">
                        <path d="M6 9.00005L12 15L18 9" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="16" />
                    </svg>
                </button>
                <ul
                    x-cloak
                    class="x-cloak mt-1 ml-6 border-l-2 border-gray-100 space-y-1"
                    id="sub-menu-1"
                    x-show="open"
                    x-collapse
                >
                    <li>
                        <a href="{{ $currentStore ? route('dealer.stores.audits.osha.index', $currentStore) : route('dealer.audit.osha.index') }}"
                           class="{{ (request()->segment(1) == 'audits' && request()->segment(2) == 'osha' || request()->segment(3) === 'audits' && request()->segment(4) === 'osha') ? 'bg-gray-100' : '' }} hover:bg-gray-100 block rounded-lg py-2 px-3 ml-3 text-sm leading-6 text-gray-700">OSHA</a>
                    </li>
                    <li>
                        <a href="{{ $currentStore ? route('dealer.stores.audits.body-shop.index', $currentStore) : route('dealer.audit.body-shop.index') }}"
                           class="{{ (request()->segment(2) == 'body-shop' || request()->segment(4) === 'body-shop') ? 'bg-gray-100' : '' }} hover:bg-gray-100 block rounded-lg py-2 px-3 ml-3 text-sm leading-6 text-gray-700">Body
                            Shop</a>
                    </li>
                    <li>
                        <a href="{{ $currentStore ? route('dealer.stores.audits.finance.index', $currentStore) : route('dealer.audit.finance.index') }}"
                           class="{{ (request()->segment(2) == 'finance' || request()->segment(4) === 'finance') ? 'bg-gray-100' : '' }} hover:bg-gray-100 block rounded-lg py-2 px-3 ml-3 text-sm leading-6 text-gray-700">GLBA
                            Walkthrough</a>
                    </li>
                    <li>
                        <a href="{{ $currentStore ? route('dealer.stores.audits.individual.index', $currentStore) : route('dealer.audit.individual.index') }}"
                           class="{{ (request()->segment(2) == 'deal-jackets' || request()->segment(4) === 'deal-jackets') ? 'bg-gray-100' : '' }} hover:bg-gray-100 block rounded-lg py-2 px-3 ml-3 text-sm leading-6 text-gray-700">Deal
                            Jackets</a>
                    </li>
                </ul>
            </div>
        @endcan
    </div>
    <!-- VENDORS -->
    @can('view-vendors')
        <div class="px-3 mb-1.5">
            <a
                href="{{ $currentStore ? route('dealer.stores.vendor.index', $currentStore) : route('dealer.vendor.index') }}"
                class="{{ (request()->segment(1) === 'vendors' || request()->segment(3) === 'vendors') ? 'bg-gray-100 text-gray-600' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }} border-transparent group py-2 px-3 rounded-lg flex items-center text-sm"
            >
                <svg class="mr-3 flex-shrink-0 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <path class="{{ (request()->segment(1) === 'vendors' || request()->segment(3) === 'vendors') ? 'stroke-gray-600' : 'stroke-gray-400 group-hover:stroke-gray-500' }}" stroke-width="1.5" d="M12.999 5c0 .351-.06.688-.171 1.001h5.17v5.17a3 3 0 1 1 0 5.658v5.17h-5.17a3 3 0 1 0-5.66 0H2.001v-5.17a3 3 0 1 0 0-5.66V6.002h5.17A3 3 0 1 1 13 5Z"/>
                </svg>
                Vendors
            </a>
        </div>
    @endcan
    <!-- RIDGEBACK -->
    @can('create-dealerships')
        @if (request()->segment(1) === 'stores' || !tenant('locations'))
        <div class="px-3 mb-1.5">
            <a
                href="{{ $currentStore ? route('dealer.stores.ridgeback.index', $currentStore) : route('dealer.ridgeback.index') }}"
                class="{{ (request()->segment(1) === 'ridgeback' || request()->segment(3) === 'ridgeback') ? 'bg-gray-100 text-gray-600' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }} border-transparent group py-2 px-3 rounded-lg flex items-center text-sm"
            >
                <svg class="mr-3 flex-shrink-0 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none">
                    <path class="{{ (request()->segment(1) === 'ridgeback' || request()->segment(3) === 'ridgeback') ? 'stroke-gray-600' : 'stroke-gray-400 group-hover:stroke-gray-500' }}" d="M14 10.5V9C14 7.89543 13.1046 7 12 7C10.8954 7 10 7.89543 10 9V10.5M8.5 10.5H15.5V16H8.5V10.5Z" stroke="currentColor" stroke-width="1.5" />
                    <path class="{{ (request()->segment(1) === 'ridgeback' || request()->segment(3) === 'ridgeback') ? 'stroke-gray-600' : 'stroke-gray-400 group-hover:stroke-gray-500' }}" d="M21 11V5C16 4.5 12 2 12 2C12 2 8 4.5 3 5V11C3 18.5 12 22 12 22C12 22 21 18.5 21 11Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                </svg>
                Ridgeback
            </a>
        </div>
        @endif
    @endcan
    <!-- Qualified Individual and up can see phishing results -->
    @can('create-manuals')
        @if($phishingIsEnabled)
        <div class="px-3 mb-1.5">
            <a
                href="{{ $currentStore ? route('dealer.stores.vendor.index', $currentStore) : route('dealer.phishing.index') }}"
                class="{{ (request()->segment(1) === 'phishing' || request()->segment(3) === 'phishing') ? 'bg-gray-100 text-gray-600' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }} border-transparent group py-2 px-3 rounded-lg flex items-center text-sm"
            >
                <svg class="mr-3 flex-shrink-0 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" color="#000" viewBox="0 0 24 24">
                    <path class="{{ (request()->segment(1) === 'phishing' || request()->segment(3) === 'phishing') ? 'stroke-gray-600' : 'stroke-gray-400 group-hover:stroke-gray-500' }}" stroke-linejoin="round" stroke-width="1.5" d="m18.004 12 1.5 1.5m0 0 1.501 1.5m-1.5-1.5 1.5-1.5m-1.5 1.5-1.5 1.5m-5.002-3 1.5 1.5m0 0 1.5 1.5m-1.5-1.5 1.5-1.5m-1.5 1.5-1.5 1.5M8 12l1.5 1.5m0 0 1.501 1.5m-1.5-1.5 1.5-1.5m-1.5 1.5-1.5 1.5M3 12l1.5 1.5m0 0L6 15m-1.5-1.5L6 12m-1.5 1.5L3 15"/>
                    <path class="{{ (request()->segment(1) === 'phishing' || request()->segment(3) === 'phishing') ? 'stroke-gray-600' : 'stroke-gray-400 group-hover:stroke-gray-500' }}" stroke-width="1.5" d="M18.626 18.099c-1.635 1.918-3.89 3.233-6.566 3.902-2.618-.586-4.966-1.95-6.68-4.034M21.496 9.06a22.456 22.456 0 0 0-.488-4.084c-3.661 0-5.408-3.043-8.98-2.976-3.624 0-5.761 3.16-9.075 2.934A21.404 21.404 0 0 0 2.5 9.06"/>
                </svg>
                Phishing
            </a>
        </div>
        @endif
    @endcan
    <!-- DOCS -->
    @can('create-users')
        @if (request()->segment(1) === 'stores' || !tenant('locations'))
        <div class="px-3 mb-1.5">
            <a
                href="{{ $currentStore ? route('dealer.stores.doc.index', $currentStore) : route('dealer.doc.index') }}"
                class="{{ (request()->routeIs('dealer.doc.index') || request()->routeIs('dealer.stores.doc.index')) ? 'bg-gray-100 text-gray-600' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }} border-transparent group py-2 px-3 rounded-lg flex items-center text-sm"
            >
                <svg class="mr-3 flex-shrink-0 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <path class="{{ (request()->routeIs('dealer.doc.index') || request()->routeIs('dealer.stores.doc.index')) ? 'stroke-gray-600' : 'stroke-gray-400 group-hover:stroke-gray-500' }}" stroke-width="1.5" d="M6.989 6.509h14.905a.1.1 0 0 1 .1.1v4.38m-11.016 9.5H2.105a.1.1 0 0 1-.1-.1V2.6a.1.1 0 0 1 .1-.1h6.871l3.08 4.008M19.013 12.487h-4.925a.1.1 0 0 0-.1.1V21.4a.1.1 0 0 0 .1.1H21.9a.1.1 0 0 0 .1-.1v-5.897l-2.987-3.016Z"/>
                </svg>
                Documents
            </a>
        </div>
        @endif
        <div class="px-3 mb-1.5">
            <a
                href="{{ global_asset('docs/osha-300.pdf') }}"
                target="_blank"
                class="text-gray-600 hover:text-gray-900 hover:bg-gray-100 border-transparent group py-2 px-3 rounded-lg flex items-center text-sm"
            >
                <svg class="mr-3 flex-shrink-0 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <path class="stroke-gray-400 group-hover:stroke-gray-500" stroke-linejoin="round" stroke-width="1.5" d="M16 18.394C16 16.867 14.21 16 12 16s-4 .672-4 1.5S9.79 19 12 19c1.657 0 3 .672 3 1.5S13.657 22 12 22c-1.285 0-2.809-.711-2.973-1.645M13.5 3.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0ZM12 5v11M16.242 5c-.893 2.115-3.31 5.334-4.242 5.738 4.5 5.016 9.166.435 10-1.734-.883 0-4.05-1.91-5.758-4.004ZM7.758 5c.893 2.115 3.31 5.334 4.242 5.738-4.5 5.016-9.166.435-10-1.734.883 0 4.05-1.91 5.758-4.004Z"/>
                </svg>

                OSHA 300 Form
            </a>
        </div>
    @endcan
    <!-- COURSES -->
    @unlessrole('super-admin|Consultant')
    @can('create-users')
    <div class="px-3 mb-1.5">
        <a
            href="{{ route('dealer.courses.index') }}"
            class="{{ (request()->is('courses')) ? 'bg-gray-100 text-gray-600' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }} border-transparent group py-2 px-3 rounded-lg flex items-center text-sm"
        >
            <svg class="mr-3 flex-shrink-0 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <path class="{{ request()->is('courses') ? 'stroke-gray-600' : 'stroke-gray-400 group-hover:stroke-gray-500' }}" stroke-linejoin="round" stroke-width="1.5" d="M7.99 2H3v19.961h17.962v-7.984"/>
                <path class="{{ request()->is('courses') ? 'stroke-gray-600' : 'stroke-gray-400 group-hover:stroke-gray-500' }}" stroke-width="1.5" d="M21.428 5.19v5.14m-2.545-3.965-.35 4.361c-1.01.967-3.632 2.195-6.061.131l-.398-4.492m3.362-4.402L9.09 4.9a.01.01 0 0 0 0 .018l2.68 1.307 3.671 1.69 3.752-1.69 2.803-1.298a.01.01 0 0 0 0-.018l-6.55-2.946a.011.011 0 0 0-.01 0Z"/>
            </svg>
            {{ __('Courses') }}
        </a>
    </div>
    @endcan
    @endunlessrole
    <!-- COURSE LIST FOR DEMO -->
    @if(tenant('id') === 'e44653a5-c049-4be0-92e3-b8aacea4bf20')
        <div class="px-3 mb-1.5">
            <a
                href="{{ route('dealer.courses.all') }}"
                class="{{ (request()->is('courses/all')) ? 'bg-gray-100 text-gray-600' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }} border-transparent group py-2 px-3 rounded-lg flex items-center text-sm"
            >
                <svg class="mr-3 flex-shrink-0 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <path class="{{ request()->is('courses/all') ? 'stroke-gray-600' : 'stroke-gray-400 group-hover:stroke-gray-500' }}" stroke-linejoin="round" stroke-width="1.5" d="M7.99 2H3v19.961h17.962v-7.984"/>
                    <path class="{{ request()->is('courses/all') ? 'stroke-gray-600' : 'stroke-gray-400 group-hover:stroke-gray-500' }}" stroke-width="1.5" d="M21.428 5.19v5.14m-2.545-3.965-.35 4.361c-1.01.967-3.632 2.195-6.061.131l-.398-4.492m3.362-4.402L9.09 4.9a.01.01 0 0 0 0 .018l2.68 1.307 3.671 1.69 3.752-1.69 2.803-1.298a.01.01 0 0 0 0-.018l-6.55-2.946a.011.011 0 0 0-.01 0Z"/>
                </svg>
                {{ __('Courses') }}
            </a>
        </div>
    @endif
    <!--  SETTINGS -->
    @can('create-stores')
        @if (request()->segment(1) === 'stores' || !tenant('locations'))
        <div class="px-3 mb-1.5">
            <a
                href="{{ $currentStore ? route('dealer.stores.settings', $currentStore) : route('dealer.dealer.settings') }}"
                class="{{ (request()->routeIs('dealer.dealer.settings') || request()->routeIs('dealer.stores.settings')) ? 'bg-gray-100 text-gray-600' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }} border-transparent group py-2 px-3 rounded-lg flex items-center text-sm"
            >
                <svg class="mr-3 flex-shrink-0 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <path class="{{ (request()->routeIs('dealer.dealer.settings') || request()->routeIs('dealer.stores.settings')) ? 'stroke-gray-600' : 'stroke-gray-400 group-hover:stroke-gray-500' }}" stroke-linejoin="round" stroke-width="1.5" d="M14.953 2H9.047v2.582L7.155 5.694 4.953 4.402 2 9.598l2.202 1.291v2.222L2 14.4l2.953 5.197 2.202-1.292 1.892 1.113V22h5.906v-2.581l1.892-1.113 2.202 1.292L22 14.402l-2.201-1.291v-2.222L22 9.6l-2.953-5.197-2.202 1.292-1.892-1.112V2Z"/>
                    <path class="{{ (request()->routeIs('dealer.dealer.settings') || request()->routeIs('dealer.stores.settings')) ? 'stroke-gray-600' : 'stroke-gray-400 group-hover:stroke-gray-500' }}" stroke-width="1.5" d="M15.5 12a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"/>
                </svg>

                Settings
            </a>
        </div>
        @endif
    @endcan

    @if(tenant('locations'))
        @if(request()->segment(1) != 'stores')
        <!--  Global Settings -->
        @role('super-admin')
        <div class="px-3 mb-1.5">
            <a
                href="{{ $currentStore ? route('dealer.settings.global', $currentStore) : route('dealer.settings.global') }}"
                class="{{ (request()->routeIs('dealer.settings.global') || request()->routeIs('dealer.settings.global')) ? 'bg-gray-100 text-gray-600' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }} border-transparent group py-2 px-3 rounded-lg flex items-center text-sm"
            >
                <svg class="mr-3 flex-shrink-0 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <path class="{{ (request()->routeIs('dealer.settings.global') || request()->routeIs('dealer.settings.global')) ? 'stroke-gray-600' : 'stroke-gray-400 group-hover:stroke-gray-500' }}" stroke-linejoin="round" stroke-width="1.5" d="M14.953 2H9.047v2.582L7.155 5.694 4.953 4.402 2 9.598l2.202 1.291v2.222L2 14.4l2.953 5.197 2.202-1.292 1.892 1.113V22h5.906v-2.581l1.892-1.113 2.202 1.292L22 14.402l-2.201-1.291v-2.222L22 9.6l-2.953-5.197-2.202 1.292-1.892-1.112V2Z"/>
                    <path class="{{ (request()->routeIs('dealer.settings.global') || request()->routeIs('dealer.settings.global')) ? 'stroke-gray-600' : 'stroke-gray-400 group-hover:stroke-gray-500' }}" stroke-width="1.5" d="M15.5 12a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"/>
                </svg>
                Global Settings
            </a>
        </div>
        @endrole
        @endif
    @endif

    <!--  LOGS -->
    @can('delete-stores')
        <div class="px-3 mb-1.5">
            <a
                href="{{ $currentStore ? route('dealer.logs.index', $currentStore) : route('dealer.logs.index') }}"
                class="{{ (request()->routeIs('dealer.logs.index') || request()->routeIs('dealer.logs.index')) ? 'bg-gray-100 text-gray-600' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }} border-transparent group py-2 px-3 rounded-lg flex items-center text-sm"
            >
                <svg class="mr-3 flex-shrink-0 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <path class="{{ (request()->routeIs('dealer.logs.index') || request()->routeIs('dealer.logs.index')) ? 'stroke-gray-600' : 'stroke-gray-400 group-hover:stroke-gray-500' }}" stroke-linejoin="round" stroke-width="1.5" d="M2.998 21h18V3h-18v18Z"/>
                    <path class="{{ (request()->routeIs('dealer.logs.index') || request()->routeIs('dealer.logs.index')) ? 'stroke-gray-600' : 'stroke-gray-400 group-hover:stroke-gray-500' }}" stroke-width="1.5" d="M8.998 21V3M20.998 9h-18M20.998 15h-18"/>
                </svg>
                Logs
            </a>
        </div>
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
            <!-- Global Settings -->
            @role('super-admin')
                <a
                    href="{{ route('dealer.settings.global') }}"
                    class="{{ (request()->segment(1) == 'global-settings') ? 'bg-arm-blue-50 text-arm-blue-600 border-arm-blue-600' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} border-transparent group border-l-4 py-2 px-3 flex items-center text-xs"
                >
                   Global Settings
                </a>
            @endrole
        </div>
    </div>
    @endif
    @endcan
    @endif
</div>
