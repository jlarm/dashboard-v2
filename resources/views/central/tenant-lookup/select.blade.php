<x-guest-layout>
    <div class="max-w-md mx-auto pt-32">
        <div class="text-center">
            <h1 class="font-medium text-xl text-gray-800">Select Your Dealership</h1>
            <p class="text-xs mb-5">This email is associated with multiple dealerships. Please select one to continue.</p>
        </div>

        <div class="bg-white overflow-hidden rounded-md border p-5">
            <form method="POST" action="{{ route('select-tenant') }}">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">

                <div>
                    <x-input-label for="dealership" value="Select Dealership" />
                    <select
                        id="dealership"
                        name="dealership"
                        required
                        class="mt-1 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"
                    >
                        <option value="">Select a dealership...</option>
                        @foreach($dealerships as $dealership)
                            <option value="{{ $dealership['id'] }}">
                                {{ $dealership['name'] }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('dealership')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-primary-button class="w-full justify-center">
                        Continue to Login
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
