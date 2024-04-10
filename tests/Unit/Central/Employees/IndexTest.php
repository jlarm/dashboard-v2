<?php

use App\Http\Livewire\Central\Employee\Index;
use App\Models\User;

test('render', function () {
    $user = User::factory()->create();

    $component = Livewire::actingAs($user)->test(Index::class);

    $component->assertOk();
});
