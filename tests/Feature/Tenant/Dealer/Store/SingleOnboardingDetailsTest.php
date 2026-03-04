<?php

declare(strict_types=1);

use App\Http\Livewire\Dealer\Store\SingleOnboardingDetails;
use App\Models\Dealer\Store;
use Livewire\Livewire;

it('renders a 911-safe dynamic mask for emergency phone fields', function (): void {
    $this->actingAs($this->consultant);

    $store = Store::query()->firstOrFail();

    Livewire::test(SingleOnboardingDetails::class, ['store' => $store])
        ->assertSeeHtml('id="pep"')
        ->assertSeeHtml('id="fep"')
        ->assertSeeHtml("x-mask:dynamic=\"\$input.replace(/\\D/g, '') === '911' ? '999' : '999-999-9999'\"");
});
