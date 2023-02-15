<?php

use App\Models\User;
use function Pest\Laravel\get;

it('cannot be accessed by guest', function () {
    get(route('dealerships.index'))->assertRedirect(route('login'));
});

it('lists created dealerships', function () {
    // Arrange
    $user = User::first()->get();

    // Act
    $this->actingAs($user);
    get(route('dealerships.index'))
        ->assertOk()
        ->assertSee('Liberty Auto Plaza');
});

it('does not list other dealerships', function () {
    // Arrange
});
