<?php

declare(strict_types=1);

it('can access dashboard when logged in', function () {
    $this->actingAs($this->consultant)
        ->get(route('dealer.dashboard'))
        ->assertOk();
});
