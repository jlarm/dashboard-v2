<div class="shadow-sm border rounded-lg p-6">
    <x-table>
        <x-slot:head>
            <x-table.row>
                <x-table.heading class="w-64">Date</x-table.heading>
                <x-table.heading class="w-32">Total Audits</x-table.heading>
                <x-table.heading class="w-24">Pass</x-table.heading>
                <x-table.heading class="w-24">Fail</x-table.heading>
                <x-table.heading class="w-24">High Risk</x-table.heading>
                <x-table.heading class="w-48">Grade</x-table.heading>
                <x-table.heading class="w-16"></x-table.heading>
            </x-table.row>
        </x-slot:head>
        <x-slot:body>
            @forelse($dealJacketGroups as $dealJacketGroup)
                <livewire:tenant.audit.deal-jacket.group-index-item :dealJacketGroup="$dealJacketGroup" wire:key="{{ $dealJacketGroup->id }}" />
            @empty

            @endforelse
        </x-slot:body>
    </x-table>
    <div class="mt-5">
        {{ $dealJacketGroups->links() }}
    </div>
</div>
