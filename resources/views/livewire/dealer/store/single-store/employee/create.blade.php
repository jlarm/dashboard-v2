<div
    class="px-6 py-5 sm:flex sm:items-center sm:justify-between">
    <div class="min-w-0 flex-1">
        <h1 class="text-4xl font-bold text-arm-blue-900 sm:truncate leading-normal">Create Employee</h1>
    </div>
    <a
        class="inline-flex items-center px-4 py-2 bg-arm-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-arm-blue-700 focus:bg-arm-blue-700 active:bg-arm-blue-900 focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
        href="{{ route('dealer.stores.employees', $store) }}"
    >
        Back to Employees
    </a>
</div>

<div class="px-6">
    <div class="border rounded-md p-6">
        <livewire:dealer.employee.create />
    </div>
</div>
