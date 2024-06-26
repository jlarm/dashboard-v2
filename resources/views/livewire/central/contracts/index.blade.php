<div class="space-y-5">
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-xl font-bold leading-none tracking-tight text-neutral-900">Contracts</h1>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
            <div class="flex justify-end">
                <x-primary-link-button href="{{ route('contracts.create') }}">Create</x-primary-link-button>
            </div>
        </div>
    </div>
    <div class="p-5 border border-gray-200 shadow-sm rounded-xl">
        <x-table>
            <x-slot name="head">
                @can('delete-users')
                <x-table.heading>Id</x-table.heading>
                <x-table.heading>Consultant</x-table.heading>
                @endcan
                <x-table.heading>Dealership</x-table.heading>
                <x-table.heading>Status</x-table.heading>
                <x-table.heading></x-table.heading>
            </x-slot>
            <x-slot name="body">
                @forelse($contracts as $contract)
                    <livewire:central.contracts.index-item :contract="$contract" :key="$contract->id" />
                @empty
                    <x-table.row>
                        <x-table.cell colspan="4">
                            <div class="text-center">
                                <h3 class="mt-2 text-sm font-semibold text-gray-900">No contracts</h3>
                                <p class="mt-1 text-sm text-gray-500">Get started by creating a new contract.</p>
                                <div class="mt-6">
                                    <a href="{{ route('contracts.create') }}" type="button" class="inline-flex items-center rounded-md bg-arm-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-arm-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-arm-blue-600">
                                        <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                                        </svg>
                                        Add Contract
                                    </a>
                                </div>
                            </div>
                        </x-table.cell>
                    </x-table.row>
                @endforelse
            </x-slot>
        </x-table>
    </div>
</div>
