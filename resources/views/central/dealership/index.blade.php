<x-app-layout>
    <div class="bg-white rounded-md p-6">
        <div>
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-xl font-bold leading-none tracking-tight text-neutral-900">Dealerships</h1>
                </div>
                <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                    <div class="flex justify-end">
                        <a
                            class="inline-flex items-center px-4 py-2 bg-arm-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-arm-blue-700 focus:bg-arm-blue-700 active:bg-arm-blue-900 focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            href="{{ route('dealerships.create') }}">Add Dealership</a>
                    </div>
                </div>
            </div>
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-10"
                     role="alert">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif
            @can('delete-users')
                <livewire:central.dealership.index/>
            @endcan
            @cannot('delete-users')
                <livewire:central.dealership.consultant-index/>
            @endcannot
        </div>
    </div>
</x-app-layout>
