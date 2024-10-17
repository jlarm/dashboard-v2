<x-guest-layout>
    <div class="max-w-sm mx-auto pt-32">
        <div class="text-center">
            <h1 class="font-medium text-xl text-gray-800">{{ tenant('name') }}</h1>
            <p class="text-xs mb-5">Please create a password to complete your registration</p>
        </div>
        <div class="bg-white overflow-hidden rounded-md border p-5" x-data>
            <form method="POST" action="{{ route('dealer.employees.store') }}">
                @csrf
                <input type="hidden" id="id" name="id" value="{{ $invite->id }}">

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')"/>

                    <x-text-input id="password" class="block mt-1 w-full"
                                  type="password"
                                  name="password"
                                  required autocomplete="new-password"/>

                    <x-input-error :messages="$errors->get('password')" class="mt-2"/>
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')"/>

                    <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                  type="password"
                                  name="password_confirmation" required/>

                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2"/>
                </div>
                <div class="mt-4">
                    <x-primary-button>
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
