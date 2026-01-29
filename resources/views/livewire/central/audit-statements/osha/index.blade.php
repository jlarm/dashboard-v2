<div class="bg-white rounded-md p-6 flex flex-col space-y-5">
    <div>
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-xl font-bold leading-none tracking-tight text-neutral-900">OSHA Violation Statements</h1>
            </div>
            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none flex gap-3">
                <x-button size="sm" target="_blank" href="{{ route('osha-violations.print') }}">Print View</x-button>
                @role('super-admin')
                    <x-button href="{{ route('osha-violations.create') }}" variant="primary" size="sm">Add Violation</x-button>
                @endrole
            </div>
        </div>
        <div class="mt-8 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <x-table>
                        <x-slot:head>
                            <x-table.row>
                                <x-table.heading>Violation</x-table.heading>
                                <x-table.heading>Weight</x-table.heading>
                                <x-table.heading></x-table.heading>
                            </x-table.row>
                        </x-slot:head>
                        <x-slot:body>
                            @foreach($violations as $violation)
                                <x-table.row>
                                    <x-table.cell>{{ Str::limit($violation->statement, 100) }}</x-table.cell>
                                    <x-table.cell>{{ $violation->weight }}</x-table.cell>
                                    <x-table.cell class="text-right">
                                        <x-button href="{{ route('osha-violations.edit', $violation) }}" size="xs" variant="ghost">Edit</x-button>
                                    </x-table.cell>
                                </x-table.row>
                            @endforeach
                        </x-slot:body>
                    </x-table>

                    <div class="py-5">
                        {{ $violations->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
