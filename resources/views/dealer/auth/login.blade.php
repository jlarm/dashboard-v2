<x-guest-layout>
    <!-- Session Status -->
    <div class="flex min-h-full">
        <div class="flex flex-1 flex-col justify-center px-4 py-12 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
            <div class="mx-auto w-full max-w-sm lg:w-96">
                <div>
                    <x-application-logo class="w-64 h-auto fill-current text-gray-500"/>
                    <h2 class="mt-8 text-2xl font-bold leading-9 tracking-tight text-gray-900">Sign in to your account</h2>
                    <x-auth-session-status class="mb-4" :status="session('status')"/>
                </div>

                <div class="mt-10">
                    <div>
                        <form method="POST" action="{{ route('login') }}" class="space-y-6">
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
                                        value="{{ request()->get('email', old('email')) }}"
                                        class="block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"
                                    >
                                </div>
                                <x-input-error :messages="$errors->get('email')" class="mt-2"/>
                            </div>

                            <div>
                                <label for="password"
                                       class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                                <div class="mt-2">
                                    <input
                                        id="password"
                                        name="password"
                                        type="password"
                                        autocomplete="current-password"
                                        required
                                        class="block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-arm-blue-600 sm:text-sm sm:leading-6"
                                    >
                                </div>
                                <x-input-error :messages="$errors->get('password')" class="mt-2"/>
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <input
                                        id="remember-me"
                                        name="remember"
                                        type="checkbox"
                                        class="h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"
                                    >
                                    <label for="remember-me" class="ml-3 block text-sm leading-6 text-gray-700">Remember
                                        me</label>
                                </div>

                                <div class="text-sm leading-6">
                                    @if (Route::has('password.request'))
                                        <a
                                            href="{{ route('password.request') }}"
                                            class="font-semibold text-arm-blue-600 hover:text-arm-blue-500"
                                        >
                                            Forgot password?
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <div>
                                <button type="submit"
                                        class="flex w-full justify-center rounded-md bg-arm-blue-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-arm-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-arm-blue-600">
                                    Sign in
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
