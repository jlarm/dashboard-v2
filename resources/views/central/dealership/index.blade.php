<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dealerships') }}
            </h2>
            <div class="flex space-x-5">
                <a
                    class="inline-flex items-center px-4 py-2 bg-arm-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-arm-blue-700 focus:bg-arm-blue-700 active:bg-arm-blue-900 focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    href="{{ route('dealerships.create') }}">Add Dealership</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 px-5 lg:px-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @can('delete-users')
                <livewire:central.dealership.index/>
            @endcan
            @cannot('delete-users')
                <livewire:central.dealership.consultant-index/>
            @endcannot
        </div>
    </div>
</x-app-layout>
