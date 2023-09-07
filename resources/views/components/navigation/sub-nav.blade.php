<div>
    <nav class="items-center flex-1 hidden mx-auto space-x-2 text-sm text-gray-700 sm:flex">
        <a href="#"
           class="px-3 py-2 transition-colors duration-300 bg-white rounded-md hover:bg-gray-100 hover:text-arm-blue-600">Employees</a>
        <a href="#"
           class="px-3 py-2 transition-colors duration-300 bg-white rounded-md hover:bg-gray-100 hover:text-arm-blue-600">Vendors</a>
        <a href="#"
           class="px-3 py-2 transition-colors duration-300 bg-white rounded-md hover:bg-gray-100 hover:text-arm-blue-600">IT
            Scans</a>
        <a href="#"
           class="px-3 py-2 transition-colors duration-300 bg-white rounded-md hover:bg-gray-100 hover:text-arm-blue-600">Manuals</a>
        <a href="#"
           class="px-3 py-2 transition-colors duration-300 bg-white rounded-md hover:bg-gray-100 hover:text-arm-blue-600">Courses</a>
        <a
            href="{{ route('dealer.onboarding.index', $store) }}"
            class="{{ request()->is('stores/'.$store->slug.'/onboarding') ? 'bg-gray-100 font-medium text-gray-700' : 'bg-white' }} px-3 py-2 transition-colors duration-300 bg-white rounded-md hover:bg-gray-100 hover:text-arm-blue-600"
        >
            Dealer Info
        </a>
    </nav>
</div>
