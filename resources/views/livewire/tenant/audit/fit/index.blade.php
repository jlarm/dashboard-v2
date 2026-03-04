<div>
    <x-slot name="header">
        <x-slot name="pageTitle">Fit Tests</x-slot>
    </x-slot>
    <x-slot name="actions">
        <x-armp.button variant="primary" size="sm" href="{{ global_asset('docs/fit-test-form.pdf') }}" target="_blank">Download Form</x-armp.button>
    </x-slot>
    <div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="border rounded-md p-5">
                <x-table>
                    <x-slot name="head">
                        <x-table.row>
                            <x-table.heading>Employee Name</x-table.heading>
                            <x-table.heading>Test Date</x-table.heading>
                            <x-table.heading></x-table.heading>
                        </x-table.row>
                    </x-slot>
                    <x-slot name="body">
                        @forelse($docs as $doc)
                            <livewire:tenant.audit.fit.index-item :fit-test-doc="$doc" :wire:key="$doc->id" />
                        @empty
                            <x-table.row>
                                <x-table.cell>
                                    <p>No fit test have been uploaded.</p>
                                </x-table.cell>
                            </x-table.row>
                        @endforelse
                    </x-slot>
                </x-table>
            </div>
            <div class="border rounded-md p-5">
                @can('create-dealerships')
                <livewire:tenant.audit.fit.create />
                @endcan
            </div>
        </div>
    </div>
</div>
