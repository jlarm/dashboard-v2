<div class="p-6">
    <div class="flex justify-between items-end">
        <h1 class="text-4xl font-bold text-arm-blue-900 sm:truncate leading-normal">ISP Manuals</h1>
        <a href="{{ request()->segment(1) != 'stores' ? route('dealer.manual.isp.create') : route('dealer.stores.manuals.isp.create', $store) }}" class="inline-flex items-center px-4 py-2 bg-arm-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-arm-blue-700 focus:bg-arm-blue-700 active:bg-arm-blue-900 focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">Sign Manual</a>
    </div>
    <div class="w-full bg-white border rounded-md p-6 mt-6">
        <div>
            <div class="inline-block min-w-full align-middle">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead>
                    <tr>
                        <th scope="col" class="whitespace-nowrap py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Date Completed</th>
                        <th scope="col" class="relative whitespace-nowrap py-3.5 pl-3 pr-4 sm:pr-0"></th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse($manuals as $manual)
                        <livewire:dealer.manual.isp.index-item :manual="$manual" :key="$manual->id"/>
                    @empty
                        <tr>
                            <td colspan="7"
                                class="px-4 py-4 text-center text-xl text-arm-blue-500 font-medium sm:pr-6 space-x-3">
                                <div class="text-center">
                                    <h3 class="mt-2 text-sm font-semibold text-gray-900">No signed manuals</h3>
                                    <div class="mt-6">
                                        <a href="{{ request()->segment(1) != 'stores' ? route('dealer.manual.isp.create') : route('dealer.stores.manuals.isp.create', $store) }}" class="inline-flex items-center rounded-md bg-arm-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-arm-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-arm-blue-600">
                                            Sign Manual
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
