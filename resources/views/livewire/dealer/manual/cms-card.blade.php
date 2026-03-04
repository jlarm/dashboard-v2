<div class="bg-gray-50 border border-gray-300 overflow-hidden rounded-lg hover:shadow-xl transition">
    <div class="p-6 text-gray-900">
        <h2 class="text-2xl font-bold mb-5">CMS</h2>
        <div class="flow-root">
            <ul role="list" class="-my-5 divide-y divide-gray-200">
                <li class="py-4">
                    <div class="flex items-end space-x-4">
                        @can('create-stores')
                            <div class="min-w-0 flex-1">
                                <a href="{{ route('dealer.manual.cms.index') }}"
                                   class="inline-flex items-center rounded-full border border-gray-300 bg-white px-2.5 py-0.5 text-sm font-medium leading-5 text-gray-700 shadow-sm hover:bg-gray-50">
                                    Start
                                </a>
                            </div>
                        @endcan
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
