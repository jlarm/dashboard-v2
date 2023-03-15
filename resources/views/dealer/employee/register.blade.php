<x-guest-layout>
    <form method="POST" action="{{ route('dealer.employees.store') }}">
        @csrf
        <input type="hidden" id="id" name="id" value="{{ $invite->id }}">

        <!-- Phone -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Phone')"/>

            <x-text-input id="phone" class="block mt-1 w-full"
                          type="tel"
                          name="phone" :value="old('phone')" required autofocus/>

            <x-input-error :messages="$errors->get('phone')" class="mt-2"/>
        </div>

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
</x-guest-layout>
