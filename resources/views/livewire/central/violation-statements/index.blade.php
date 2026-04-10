<div>
    <div class="flex flex-col gap-3 mb-4 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:gap-3">
            <x-input id="vs-search" placeholder="Search violations..." wire:model.debounce.300ms="search" />
            <select wire:model="category" class="h-10 rounded-md border border-gray-300 bg-white pl-3 pr-8 text-sm text-gray-700 shadow-sm focus:border-arm-blue-500 focus:outline-none focus:ring-2 focus:ring-arm-blue-500">
                <option value="">All categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->value }}">{{ $cat->label() }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex items-center gap-2">
            <x-armp.button href="{{ route('violation-statements.print') }}" variant="ghost" target="_blank">Print</x-armp.button>
            <x-armp.button href="{{ route('violation-statements.create') }}" variant="primary">Add Violation</x-armp.button>
        </div>
    </div>

    <div class="-mx-4 overflow-x-auto sm:mx-0">
        <div class="inline-block min-w-full align-middle px-4 sm:px-0">
            <x-table>
                <x-slot:head>
                    <x-table.row>
                        <x-table.heading>Statement</x-table.heading>
                        <x-table.heading>Weight</x-table.heading>
                        <x-table.heading class="hidden sm:table-cell">Categories</x-table.heading>
                        <x-table.heading></x-table.heading>
                    </x-table.row>
                </x-slot:head>
                <x-slot:body>
                    @forelse($statements as $statement)
                    <x-table.row>
                        <x-table.cell>{{ Str::limit($statement->statement, 100) }}</x-table.cell>
                        <x-table.cell>{{ $statement->weight }}</x-table.cell>
                        <x-table.cell class="hidden sm:table-cell">
                            {{ collect($statement->categories)->map(fn ($c) => \App\Enums\ViolationStatementCategory::from($c)->label())->join(', ') }}
                        </x-table.cell>
                        <x-table.cell class="text-right">
                            <x-armp.button size="xs" variant="ghost" href="{{ route('violation-statements.edit', $statement) }}">Edit</x-armp.button>
                        </x-table.cell>
                    </x-table.row>
                    @empty
                        <x-table.row>
                            <x-table.cell colspan="4" class="text-center">No violation statements</x-table.cell>
                        </x-table.row>
                    @endforelse
                </x-slot:body>
            </x-table>
        </div>
    </div>

    <div class="mt-4">
        {{ $statements->links() }}
    </div>
</div>
