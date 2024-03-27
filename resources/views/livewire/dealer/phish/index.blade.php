<div>
    <div class="px-6 py-5 sm:flex sm:items-center sm:justify-between">
        <div class="w-full flex justify-between items-center">
            <h1 class="text-4xl font-bold text-arm-blue-900 sm:truncate leading-normal">Phishing Simulations</h1>
            @can('create-dealerships')
                <a
                    class="inline-flex items-center px-4 py-2 bg-arm-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-arm-blue-700 focus:bg-arm-blue-700 active:bg-arm-blue-900 focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    href="{{ route('dealer.phishing.create') }}">Create Phishing Simulation</a>
            @endcan
        </div>
    </div>

    <div class="px-6">
        <div class="border rounded-md p-6">
            <livewire:dealer.phish.table-index />
        </div>
    </div>
</div>
