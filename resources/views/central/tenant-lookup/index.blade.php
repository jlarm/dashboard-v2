<x-guest-layout>
    <div class="max-w-sm mx-auto pt-32">
        <div class="text-center">
            <x-application-icon class="w-auto h-10 mx-auto mb-3" />
            <p class="text-sm mb-5">Enter your email address to login</p>
        </div>
        <div class="bg-white overflow-hidden rounded-md border p-5" x-data>
            <form method="POST" action="{{ route('dealer-login.lookup') }}">
                @csrf

                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email Address')"/>

                    <x-text-input id="email" class="block mt-1 w-full"
                                  type="text"
                                  name="email"
                                  required autocomplete="new-email"/>

                    <x-input-error :messages="$errors->get('email')" class="mt-2"/>
                </div>

                <div class="mt-4">
                    <x-primary-button>
                        {{ __('Login') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
