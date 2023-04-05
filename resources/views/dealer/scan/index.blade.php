<x-dealer-app>
    @if(Cookie::get('sentry'))
        <livewire:dealer.scan.index/>
    @else
        <div class="max-w-md">
            <livewire:dealer.scan.login/>
        </div>
    @endif
</x-dealer-app>
