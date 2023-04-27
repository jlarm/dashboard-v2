<div class="sticky top-0 z-10 flex h-16 flex-shrink-0 bg-gray-50 shadow">
    <!-- Mobile Menu Toggle -->
    <x-navigation.mobile-menu-toggle/>
    <div class="flex flex-1 justify-between px-4">
        <div class="flex flex-1 items-center">
            <!-- Dealership Name -->
            <x-dealership-name/>
        </div>
        <div class="ml-4 flex items-center md:ml-6 space-x-5">
            @env('local')
                <x-navigation.role/>
            @endenv
            <!-- Notifications Bell -->
            {{--            <x-navigation.notifications/>--}}
            <!-- Profile dropdown -->
            <x-navigation.user-dropdown/>
        </div>
    </div>
</div>
