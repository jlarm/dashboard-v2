<?php

declare(strict_types=1);

use App\Models\SharedDocument;
use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Livewire\Livewire;

beforeEach(function () {
    $this->seed(RoleAndPermissionSeeder::class);
});

it('can see dealers documentation if super-admin', function () {
    $response = asSuperAdmin()->get(route('dealer-docs.index'));

    $response
        ->assertSee([
            'Dealer Docs',
            'Dealership Documents',
        ])
        ->assertOk();
});

it('displays upload button', function () {
    $response = asSuperAdmin()
        ->get(route('dealer-docs.index'));

    $response->assertOk()
        ->assertSee('Upload');
});

it('can see documents listed', function () {
    $user = User::factory()->create();
    $user->assignRole('super-admin');

    $doc = SharedDocument::factory()->create();

    $component = Livewire::actingAs($user)->test('central.shared-docs.index');

    $component->assertSee($doc->title);
});
