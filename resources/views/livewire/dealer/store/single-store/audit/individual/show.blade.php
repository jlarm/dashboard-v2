<div class="px-6">
    <div>
        <div class="py-5 sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-4xl font-bold text-arm-blue-900 sm:truncate leading-normal">Deal Jackets
                    for {{ $this->getQuarterNameAttribute() }} of {{ $individualAudit->audit_date->format('Y') }}</h1>
            </div>
            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                <div class="mt-4 flex sm:mt-0 sm:ml-4 space-x-5">
                    @if($individualAudit->pdf_path)
                        <livewire:dealer.audit.individual.download :individualAudit="$individualAudit"/>
                    @endif
                    @if(!$individualAudit->pdf_path)
                        <a
                            class="inline-flex items-center px-4 py-2 bg-arm-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-arm-blue-700 focus:bg-arm-blue-700 active:bg-arm-blue-900 focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            href="{{ route('dealer.stores.audits.individual.create', [$store, $individualAudit]) }}"
                        >
                            Create Audit
                        </a>
                        <livewire:dealer.audit.individual.generate :individualAudit="$individualAudit"/>
                    @endif
                </div>
            </div>
        </div>
        <div class="border rounded-md">
            <div class="p-6">
        <table class="min-w-full divide-y divide-gray-300">
            <thead>
            <tr>
                <th scope="col" class="whitespace-nowrap py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                    Customer Number
                </th>
                <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">Customer Name</th>
                <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">Manager Name</th>
                <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">Rating</th>
                <th scope="col" class="relative whitespace-nowrap py-3.5 pl-3 pr-4 sm:pr-0">
                    <span class="sr-only">Edit</span>
                </th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
            <livewire:dealer.store.single-store.audit.individual.parent-show-single :individualAudit="$individualAudit"
                                                                                    :store="$store"/>
            @foreach($audits as $audit)
                <livewire:dealer.audit.individual.show-single :individualAudit="$individualAudit" :store="$store"
                                                              :audit="$audit"/>
            @endforeach
            </tbody>
        </table>
            </div>
        </div>
    </div>
</div>
