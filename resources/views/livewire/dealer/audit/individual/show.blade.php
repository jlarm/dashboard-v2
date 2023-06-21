<table class="min-w-full divide-y divide-gray-300">
    <thead>
    <tr>
        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 lg:pl-8">
            Customer Number
        </th>
        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Customer Name</th>
        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6 lg:pr-8">
            <span class="sr-only">Edit</span>
        </th>
    </tr>
    </thead>
    <tbody class="divide-y divide-gray-200 bg-white">
    <livewire:dealer.audit.individual.parent-show-single :individualAudit="$individualAudit"
                                                         :key="$individualAudit->id"/>
    @foreach($audits as $audit)
        <livewire:dealer.audit.individual.show-single :audit="$audit" :key="$audit->id"/>
    @endforeach
    </tbody>
</table>
