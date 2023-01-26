<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $user->name }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mx-auto grid max-w-3xl grid-cols-1 gap-6 sm:px-6 lg:max-w-7xl lg:grid-flow-cold-dense lg:grid-cols-3">
                <aside class="lg:col-span-1">
                    <div class="bg-white px-4 py-5 shadow sm:rounded-lg sm:px-6">
                        <div class="flex flex-col space-y-3">
                            <div class="flex flex-col">
                                <span>{{ $user->email }}</span>
                                <span>{{ $user->phone }}</span>
                                <span>{{ $user->roles()->first()->name }}</span>
                            </div>
                            <span class="text-gray-500 text-sm">Since: {{ $user->created_at->format('F d, Y') }}</span>
                        </div>
                    </div>
                </aside>
                <section class="lg:col-start-2 lg:col-span-2">
                    <livewire:central.employee.dealership-list :user="$user" />
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
