<?php

use function Pest\Laravel\get;

it('gives back successful response for the home page', function() {
    get(route('home'))->assertOk();
});

it('give back successful response for login page', function () {
    get(route('login'))->assertOk();
});

it('give back successful response for dashboard page', function () {
    $user = \App\Models\User::create([
        'name' => 'Joe Lohr',
        'email' => 'test@autorisknow.com',
        'phone' => '2243586930',
        'password' => Hash::make('password'),
        'email_verified_at' => now(),
    ]);

    $this->actingAs($user);
    get(route('dashboard'))->assertOk();
});
