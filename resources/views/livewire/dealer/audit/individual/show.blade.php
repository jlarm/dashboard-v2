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
            {{--    <livewire:dealer.audit.individual.parent-show-single :individualAudit="$individualAudit"--}}
            {{--                                                         :key="$individualAudit->id"/>--}}
            @foreach($audits as $audit)
                <livewire:dealer.audit.individual.show-single :audit="$audit" :key="$audit->id"/>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
