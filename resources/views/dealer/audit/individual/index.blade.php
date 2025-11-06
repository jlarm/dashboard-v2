<x-dealer-app>
    <div class="bg-blue-50 border border-blue-200 text-sm text-blue-600 rounded-lg p-4 mb-4" role="alert" tabindex="-1" aria-labelledby="hs-link-on-right-label">
        <div class="flex">
            <div class="shrink-0">
                <svg class="shrink-0 size-4 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M12 16v-4"></path>
                    <path d="M12 8h.01"></path>
                </svg>
            </div>
            <div class="flex-1 md:flex md:justify-between ms-2">
                <p id="hs-link-on-right-label" class="text-sm">
                    These audits will be incorporated into the new version of Deal Jacket Audits in a future update.
                </p>
            </div>
        </div>
    </div>
    <x-slot name="header">
        <x-slot name="pageTitle">
            {{ __('Past Deal Jacket Audits') }}
        </x-slot>
    </x-slot>
    <div>
        @can('create-audits')
            <livewire:dealer.audit.individual.index :store="$store"/>
        @endcan
        @if(auth()->user()->cannot('create-audits'))
            <livewire:dealer.audit.individual.generated-report-index/>
        @endif
    </div>
</x-dealer-app>
