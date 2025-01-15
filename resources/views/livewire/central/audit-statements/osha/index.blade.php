<div class="bg-white rounded-md p-6 flex flex-col space-y-5">
    <div>
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-xl font-bold leading-none tracking-tight text-neutral-900">OSHA Violation Statements</h1>
            </div>
            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none flex gap-3">
                <x-primary-link-button target="_blank" href="{{ route('osha-violations.print') }}">Print View</x-primary-link-button>
                @role('super-admin')
                <a href="{{ route('osha-violations.create') }}" class="block rounded-md bg-arm-blue-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-arm-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-arm-blue-600">Add Violation</a>
                @endrole
            </div>
        </div>
        <div class="mt-8 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead>
                        <tr>
                            <th scope="col" class="whitespace-nowrap py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Violation</th>
                            <th scope="col" class="relative whitespace-nowrap py-3.5 pl-3 pr-4 sm:pr-0">
                                <span class="sr-only">Edit</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse($violations as $oshaViolationStatements)
                            <livewire:central.audit-statements.osha.index-item :oshaViolationStatements="$oshaViolationStatements" :wire:key="$oshaViolationStatements->id" />
                        @empty
                            <tr>
                                <td colspan="3" class="py-4 text-sm text-gray-500 text-center">No violation statements found.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    <div class="py-5">
                        {{ $violations->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
