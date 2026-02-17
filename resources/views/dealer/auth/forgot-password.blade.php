<x-guest-layout>
    <div class="flex min-h-full">
        <div class="flex flex-1 flex-col justify-center px-4 py-12 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
            <div class="mx-auto w-full max-w-sm lg:w-96">
                <div>
                    <x-application-logo class="w-64 h-auto fill-current text-gray-500"/>
                    <div class="mt-4 text-gray-600">
                        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password
                        reset link that will allow you to choose a new one.') }}
                    </div>
                </div>

                <div class="mt-10">
                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')"/>
                    <div>
                        <form method="POST" action="{{ route('dealer.password.email') }}" class="space-y-6">
                            @csrf
                            <div>
                                <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email
                                    address</label>
                                <div class="mt-2">
                                    <input
                                        id="email"
                                        name="email"
                                        type="email"
                                        autocomplete="email"
                                        required
                                        autofocus
                                        :value="old('email')"
                                        class="block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"
                                    >
                                </div>
                                <x-input-error :messages="$errors->get('email')" class="mt-2"/>
                            </div>

                            <div>
                                <button type="submit"
                                        class="flex w-full justify-center rounded-md bg-arm-blue-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-arm-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-arm-blue-600">
                                    Email Password Reset Link
                                </button>
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
