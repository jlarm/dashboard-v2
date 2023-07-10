<x-dealer-app>
    @role('super-admin|Consultant')
    @if(Cookie::get('sentry'))
        <livewire:dealer.scan.index/>
    @else
        <div class="max-w-md mx-auto">
            <livewire:dealer.scan.login/>
        </div>
    @endif
    @endrole
    <livewire:dealer.scan.report-index/>
</x-dealer-app>
