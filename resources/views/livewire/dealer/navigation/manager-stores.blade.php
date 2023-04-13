<div>
    @if(count($stores) > 1)
        @foreach($stores as $store)
            <div x-data="{ open: false }"
                 class="{{ (request()->is('store/'.$store->slug.'/*')) ? 'bg-gray-200' : '' }}">
                <button
                    x-on:click="open = ! open"
                    {{--            href="{{ route('dealer.stores.show', $store) }}"--}}
                    aria-controls="dropdown"
                    data-collapse-toggle="dropdown"
                    class="{{ (request()->is('stores/'.$store->slug)) ? 'bg-arm-blue-50 text-arm-blue-600 border-arm-blue-600' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} border-transparent border-l-4 py-2 px-3 w-full text-left flex items-center text-sm font-medium"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor"
                         class="{{ request()->is('store/'.$store->slug.'/*') ? 'text-arm-blue-500' : 'text-gray-400 group-hover:text-gray-500' }} mr-3 flex-shrink-0 h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                    </svg>
                    <span class="flex-1">{{ $store->name }}</span>
                    @if(count($stores) > 1)
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor"
                             class="w-4 h-4"
                             :class="{ 'rotate-90': open}"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                        </svg>
                    @endif

                </button>
                <ul
                    @if(count($stores) === 1)
                        x-show="{ open: true }"
                    @else
                        x-show="open"
                    @endif
                    id="dropdown"
                    class="space-y-1"
                >
                    <li>
                        <a href="{{ route('dealer.store.employees.store.employee.index', $store) }}"
                           class="{{ (request()->is('store/'.$store->slug.'/employees')) ? 'bg-arm-blue-500 text-white' : 'text-gray-900' }} flex items-center w-full p-2 text-sm font-normal transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pl-16">Employees</a>
                    </li>
                    <li>
                        <a href="{{ route('dealer.store.employees.store.vendor.index', $store) }}"
                           class="{{ (request()->is('store/'.$store->slug.'/vendors')) ? 'bg-arm-blue-100' : '' }} flex items-center w-full p-2 text-sm font-normal text-gray-900 transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pl-16">Vendors</a>
                    </li>
                    <li>
                        <a href="{{ route('dealer.store.employees.store.scan.index', $store) }}"
                           class="{{ (request()->is('store/'.$store->slug.'/scans')) ? 'bg-arm-blue-100' : '' }} flex items-center w-full p-2 text-sm font-normal text-gray-900 transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pl-16">Scans</a>
                    </li>
                    <li>
                        <a href="#"
                           class="flex items-center w-full p-2 text-sm font-normal text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pl-16">Manuals</a>
                    </li>
                    <li>
                        <a href="#"
                           class="flex items-center w-full p-2 text-sm font-normal text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pl-16">Courses</a>
                    </li>
                </ul>
            </div>
        @endforeach
    @else
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
    @endif
</div>
