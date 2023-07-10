<div class="flex justify-center flex-col text-center">
    @error('email')
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
        <strong class="font-bold">Error!</strong>
        <span class="block sm:inline">{{ $message }}</span>
    </div>
    @enderror
    <p class="my-6">Login to generate reports</p>
    <form wire:submit.prevent="login" class="space-y-6">
        <div>
            <x-text-input
                wire:model.defer="email"
                type="text"
                name="email"
                label="email"
                placeholder="Email Address"
                required
                class="w-full"
            />
        </div>
        <div>
            <x-text-input
                wire:model.defer="password"
                type="password"
                name="password"
                label="password"
                placeholder="Password"
                required
                class="w-full"
            />
        </div>
        <button
            class="w-full text-center px-4 py-2 bg-arm-blue-800 border border-transparent rounded-md
                font-semibold text-xs text-white uppercase tracking-widest hover:bg-arm-blue-700 focus:bg-arm-blue-700
                active:bg-arm-blue-900 focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2
                transition ease-in-out duration-150
            "
            type="submit"
        >
            <div wire:loading>
                <!-- Heroicon name: mini/envelope -->
                <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
            Login
        </button>
    </form>
</div>
