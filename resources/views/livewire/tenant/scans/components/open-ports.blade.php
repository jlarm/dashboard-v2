<div>
    <x-table>
        <x-slot:head>
            <x-table.row>
                <x-table.heading>Port</x-table.heading>
                <x-table.heading>Description</x-table.heading>
                <x-table.heading class="text-right">Risk Level</x-table.heading>
            </x-table.row>
        </x-slot:head>
        <x-slot:body>
            @foreach($openPorts as $openPort)
                <x-table.row>
                    <x-table.cell>
                        {{ $openPort['portNumber'] }}
                    </x-table.cell>
                    <x-table.cell>
                        {{ $openPort['portDescription'] }}
                    </x-table.cell>
                    <x-table.cell class="text-right">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider border bg-emerald-50 text-emerald-600 border-emerald-100">
                            {{ $openPort['riskLevel'] }}
                        </span>
                    </x-table.cell>
                </x-table.row>
            @endforeach
        </x-slot:body>
    </x-table>
</div>
