<x-guest-layout>
    <div class="flex min-h-full">
        <div class="flex flex-1 flex-col justify-center px-4 py-12 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
            <div class="mx-auto w-full max-w-sm lg:w-96">
                <div>
                    <x-application-logo class="w-64 h-auto fill-current text-gray-500"/>
                    <h2 class="mt-8 text-2xl font-bold leading-9 tracking-tight text-gray-900">Complete registration</h2>
                </div>

                <div class="mt-10">
                    <div>
                        <form method="POST" action="{{ route('employees.store') }}">
                            @csrf
                            <input type="hidden" id="name" name="name" value="{{ $name }}">
                            <input type="hidden" id="email" name="email" value="{{ $email }}">
                            <input type="hidden" id="role" name="role" value="{{ $role }}">

                            <!-- Phone -->
                            <div class="mt-4">
                                <x-input-label for="phone" :value="__('Phone')"/>

                                <x-text-input
                                    id="phone"
                                    class="block mt-1 w-full"
                                    type="tel"
                                    name="phone"
                                    :value="old('phone')"
                                    required
                                    autofocus
                                />

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
                    </div>

                </div>
            </div>
        </div>
        <div class="relative hidden w-0 flex-1 lg:block">
            <img class="absolute inset-0 h-full w-full object-cover"
                 src="https://armp.nyc3.digitaloceanspaces.com/dashboard-assets/login.jpg"
                 alt="">
        </div>
    </div>

</x-guest-layout>
