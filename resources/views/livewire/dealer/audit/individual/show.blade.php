<div>
    <x-table>
        <x-slot name="head">
            <x-table.row>
                <x-table.cell>Customer Number</x-table.cell>
                <x-table.cell>Customer Name</x-table.cell>
                <x-table.cell>Manager Name</x-table.cell>
                <x-table.cell>Rating</x-table.cell>
                <x-table.cell></x-table.cell>
            </x-table.row>
        </x-slot>
        <x-slot name="body">
            @foreach($audits as $audit)
                <livewire:dealer.audit.individual.show-single :audit="$audit" :key="$audit->id"/>
            @endforeach
        </x-slot>
    </x-table>
</div>
