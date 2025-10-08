<div wire:init="loadScanData">
    @if($loaded)
        <!-- Issue Counts Component -->
        @livewire('tenant.scans.components.issue-counts', ['cyrisma' => $cyrisma], key('issue-counts'))
        @livewire('tenant.scans.components.cve-list', ['cyrisma' => $cyrisma], key('cve-list'))

        <!-- Add more child components here as needed -->
        {{-- @livewire('tenant.scans.components.issues-list', ['cyrisma' => $cyrisma], key('issues-list')) --}}
        {{-- @livewire('tenant.scans.components.targets-list', ['cyrisma' => $cyrisma], key('targets-list')) --}}
    @else
        <!-- Loading Skeleton -->
        @include('livewire.tenant.scans.components.issue-counts-placeholder')
    @endif
</div>
