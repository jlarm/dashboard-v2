@props(['class' => ''])

@php($showExecutiveSummary = auth()->user()->hasAnyRole(['super-admin', 'Owner', 'GM', 'CFO', 'GSM', 'Qualified Individual']))

<div class="grid grid-cols-2 {{ $showExecutiveSummary ? 'lg:grid-cols-5' : 'lg:grid-cols-4' }} gap-2 md:gap-3 xl:gap-5 items-stretch {{ $class }}">
    <livewire:dealer.home.osha-stats/>
    <livewire:dealer.home.body-shop-stats/>
    <livewire:dealer.home.glba-stats/>
    <livewire:dealer.home.deal-jacket-stats/>
    @if($showExecutiveSummary)
        <livewire:dealer.home.executive-summary/>
    @endif
</div>
