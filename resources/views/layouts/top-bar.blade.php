<div class="sticky top-0 z-10 flex h-16 flex-shrink-0 border-b bg-white">
    <!-- Mobile Menu Toggle -->
    <x-navigation.mobile-menu-toggle/>
    <div class="flex flex-1 justify-between px-4">
        <div class="flex flex-1 items-center">
            <!-- Dealership Name -->
            <livewire:dealer.layout.current-store-name />
        </div>
        <div class="ml-4 flex items-center md:ml-6 space-x-5">

            @if(session()->has('impersonated_by'))
                <div class="bg-red-600 py-2 text-center text-white rounded text-xs px-2">
                    <div class="container mx-auto">
                        You are currently impersonating {{ auth()->user()->name }}
                        <a href="{{ route('dealer.stop.impersonation') }}" class="underline font-semibold">Return to your account</a>
                    </div>
                </div>
            @endif
            <livewire:dealer.components.notifications />
            <x-navigation.user-dropdown/>
        </div>
    </div>
</div>
