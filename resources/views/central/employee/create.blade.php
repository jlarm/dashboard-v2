<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Invite Employee') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('invite.send') }}">
                        @csrf

                        <div class="mt-4">
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required />
                            @error('name')
                            <div class="text-red-500 text-sm mt-2">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                            @error('email')
                                <div class="text-red-500 text-sm mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <x-input-label for="role" :value="__('Role')" />
                            <select id="role" name="role" class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                                <option></option>
                                <option>Admin</option>
                                <option>Consultant</option>
                            </select>
                            @error('role')
                                <div class="text-red-500 text-sm mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <x-primary-button>
                                {{ __('+ Invite Employee') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
