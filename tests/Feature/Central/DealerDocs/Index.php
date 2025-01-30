<?php

declare(strict_types=1);

use Database\Seeders\RoleAndPermissionSeeder;

beforeEach(function () {
    $this->seed(RoleAndPermissionSeeder::class);
});

it('can see dealers documentation if super-admin', function () {
    $response = asSuperAdmin()->get(route('dealer-docs.index'));

    $response
        ->assertSee('Dealer Docs')
        ->assertSee('Dealership Documents')
        ->assertOk();
});

it('can not see dealers documentation if consultant', function () {
   $response = asConsultant()
       ->get(route('dealer-docs.index'));

   $response->assertForbidden();
});
