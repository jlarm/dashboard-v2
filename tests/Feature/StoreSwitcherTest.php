<?php

it('can render the store switcher', function () {
    $store = \App\Models\Dealer\Store::first();

    session(['stores' => $store->name]);

    Livewire::test(\App\Http\Livewire\Dealer\Navigation\StoreSwitcher::class)
        ->assertSee($store->name);
});
