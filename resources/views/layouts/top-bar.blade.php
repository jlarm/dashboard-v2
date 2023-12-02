<div class="sticky top-0 z-10 flex h-16 flex-shrink-0 border-b bg-white">
    <!-- Mobile Menu Toggle -->
    <x-navigation.mobile-menu-toggle/>
    <div class="flex flex-1 justify-between px-4">
        <div class="flex flex-1 items-center">
            <!-- Dealership Name -->
            <livewire:dealer.layout.current-store-name />
        </div>
        <div class="ml-4 flex items-center md:ml-6 space-x-5">
            <x-navigation.user-dropdown/>
        </div>
    </div>
</div>
