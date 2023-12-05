<x-store-app :title="$store->name">
    <div class="border-b border-gray-200 py-4 sm:flex sm:items-center sm:justify-between">
        <div class="min-w-0 flex-1">
            <h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">Employees</h1>
        </div>
        <div class="mt-4 flex space-x-5 sm:mt-0 sm:ml-4">
            <button
                onclick="Livewire.emit('modal.open', 'dealer.employee.invite', @js(['currentStore' => $store->id]))"
                class="inline-flex items-center px-4 py-2 bg-arm-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-arm-blue-700 focus:bg-arm-blue-700 active:bg-arm-blue-900 focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
            >
                Add Employee
            </button>
        </div>
    </div>
    <div class="py-12">
{{--        <livewire:dealer.store.multi.employee-index :store="$store"/>--}}
    </div>
</x-store-app>
