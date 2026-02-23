@props(['class' => ''])

<div class="grid grid-cols-2 lg:grid-cols-4 gap-2 md:gap-3 xl:gap-5 {{ $class }}">
    <livewire:dealer.home.osha-stats/>
    <livewire:dealer.home.body-shop-stats/>
    <livewire:dealer.home.glba-stats/>
    <livewire:dealer.home.deal-jacket-stats/>
</div>
