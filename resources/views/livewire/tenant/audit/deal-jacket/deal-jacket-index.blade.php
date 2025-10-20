<div class="space-y-5">
    @if($dealJackets->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <livewire:tenant.audit.deal-jacket.components.totals-progress-bar
            :dealJacketGroup="$dealJacketGroup"
        />
        <livewire:tenant.audit.deal-jacket.components.issue-list :dealJacketGroup="$dealJacketGroup" />
    </div>
    @endif
    <div class="shadow-sm border rounded-lg p-6">
        <x-table>
            <x-slot:head>
                <x-table.row>
                    <x-table.heading>Customer Name</x-table.heading>
                    <x-table.heading>Date</x-table.heading>
                    <x-table.heading>Total Passed</x-table.heading>
                    <x-table.heading>Total Failed</x-table.heading>
                    <x-table.heading>Total High Risk</x-table.heading>
                    <x-table.heading>Grade</x-table.heading>
                    <x-table.heading></x-table.heading>
                </x-table.row>
            </x-slot:head>
            <x-slot:body>
                @forelse($dealJackets as $dealJacket)
                    <livewire:tenant.audit.deal-jacket.deal-jacket-index-item
                        :dealJacketGroup="$dealJacketGroup"
                        :dealJacket="$dealJacket"
                        :key="$dealJacket->id"
                        :wire:key="'deal-jacket-'.$dealJacket->id"
                    />
                @empty
                    <x-table.row>
                        <x-table.cell colSpan="6">
                            <div class="p-5 min-h-100  flex flex-col justify-center items-center text-center mt-10">
                                <svg class="w-48 mx-auto" width="87" height="65" viewBox="0 0 87 65" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect y="35" width="6" height="30" fill="currentColor" class="fill-gray-200 dark:fill-neutral-700"/>
                                    <rect x="9" y="20" width="6" height="45" fill="currentColor" class="fill-gray-200 dark:fill-neutral-700"/>
                                    <rect x="18" y="25" width="6" height="40" fill="currentColor" class="fill-gray-200 dark:fill-neutral-700"/>
                                    <rect x="27" width="6" height="65" fill="currentColor" class="fill-gray-200 dark:fill-neutral-700"/>
                                    <rect x="36" y="5" width="6" height="60" fill="currentColor" class="fill-gray-200 dark:fill-neutral-700"/>
                                    <rect x="45" y="40" width="6" height="25" fill="currentColor" class="fill-gray-200 dark:fill-neutral-700"/>
                                    <rect x="54" y="25" width="6" height="40" fill="currentColor" class="fill-gray-200 dark:fill-neutral-700"/>
                                    <rect x="63" y="12" width="6" height="53" fill="currentColor" class="fill-gray-200 dark:fill-neutral-700"/>
                                    <rect x="72" width="6" height="65" fill="currentColor" class="fill-gray-200 dark:fill-neutral-700"/>
                                    <rect x="81" y="44" width="6" height="21" fill="currentColor" class="fill-gray-200 dark:fill-neutral-700"/>
                                </svg>

                                <div class="max-w-sm mx-auto">
                                    <p class="mt-2 font-medium text-gray-800 dark:text-neutral-200">
                                        No data
                                    </p>
                                </div>
                            </div>
                        </x-table.cell>
                    </x-table.row>
                @endforelse
            </x-slot:body>
        </x-table>
    </div>
</div>
