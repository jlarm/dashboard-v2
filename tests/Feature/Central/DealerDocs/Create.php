<?php

declare(strict_types=1);

use App\Http\Livewire\Central\SharedDocs\Create;
use App\Models\SharedDocument;
use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Livewire\Livewire;

beforeEach(function () {
    $this->seed(RoleAndPermissionSeeder::class);
});

it('can see dealers documentation create page if super-admin', function () {
    $response = asSuperAdmin()->get(route('dealer-docs.create'));

    $response
        ->assertSee([
            'Upload Document',
            'These documents will be accessible to all dealerships.',
        ])
        ->assertOk();
});

it('can upload a document', function () {
    $user = User::factory()->create();
    $user->assignRole('super-admin');

    $component = Livewire::actingAs($user)->test(Create::class);

    $component->set('title', 'Test Document');
    $component->set('url', 'https://test.com');

    $component->call('save');

    $doc = SharedDocument::first();

    expect($doc->title)->toBe('Test Document')
        ->and($doc->url)->toBe('https://test.com');
});

it('can not upload a document without title', function () {
    $user = User::factory()->create();
    $user->assignRole('super-admin');

    $component = Livewire::actingAs($user)->test(Create::class);

    $component->set('title', '');
    $component->set('url', 'https://test.com');

    $component->call('save');

    $component->assertHasErrors([
        'title' => 'required',
    ]);
});
