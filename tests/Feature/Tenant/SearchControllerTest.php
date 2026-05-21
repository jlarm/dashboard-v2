<?php

declare(strict_types=1);

use App\Models\Dealer\Course;
use App\Models\Dealer\Store;
use App\Models\Dealer\Vendor;
use App\Models\DealerDoc;
use App\Models\User;
use Spatie\Permission\PermissionRegistrar;

beforeEach(function (): void {
    app()->make(PermissionRegistrar::class)->forgetCachedPermissions();
});

it('redirects guests to login', function (): void {
    $this->get(route('dealer.search', ['q' => 'acme']))
        ->assertRedirect();
});

it('returns no groups for a term shorter than two characters', function (): void {
    Vendor::query()->create([
        'name' => 'Acme Industries',
        'contact_name' => 'Alice',
        'contact_email' => 'alice@acme.test',
    ]);

    $this->actingAs($this->consultant)
        ->getJson(route('dealer.search', ['q' => 'a']))
        ->assertOk()
        ->assertExactJson(['groups' => []]);
});

it('finds vendors by name', function (): void {
    Vendor::query()->create([
        'name' => 'Acme Industries',
        'contact_name' => 'Alice',
        'contact_email' => 'alice@acme.test',
    ]);
    Vendor::query()->create([
        'name' => 'Beta Holdings',
        'contact_name' => 'Bob',
        'contact_email' => 'bob@beta.test',
    ]);

    $response = $this->actingAs($this->consultant)
        ->getJson(route('dealer.search', ['q' => 'acme']))
        ->assertOk();

    $vendors = collect($response->json('groups'))->firstWhere('key', 'vendors');

    expect($vendors)->not->toBeNull()
        ->and($vendors['items'])->toHaveCount(1)
        ->and($vendors['items'][0]['title'])->toBe('Acme Industries')
        ->and($vendors['items'][0]['type'])->toBe('vendor');
});

it('finds employees by name', function (): void {
    $employee = User::query()->create([
        'name' => 'Searchable Sam',
        'email' => 'sam@test-tenant.localhost',
        'password' => bcrypt('password'),
    ]);
    $employee->assignRole('Employee');

    $response = $this->actingAs($this->consultant)
        ->getJson(route('dealer.search', ['q' => 'Searchable']))
        ->assertOk();

    $employees = collect($response->json('groups'))->firstWhere('key', 'employees');

    expect($employees)->not->toBeNull()
        ->and($employees['items'])->toHaveCount(1)
        ->and($employees['items'][0]['title'])->toBe('Searchable Sam');
});

it('excludes consultants from employee results, matching the employee index', function (): void {
    $this->consultant->update(['name' => 'Hidden Consultant']);

    $response = $this->actingAs($this->consultant)
        ->getJson(route('dealer.search', ['q' => 'Hidden Consultant']))
        ->assertOk();

    expect(collect($response->json('groups'))->firstWhere('key', 'employees'))->toBeNull();
});

it('finds courses by name', function (): void {
    Course::query()->create([
        'name' => 'Forklift Safety Training',
        'slug' => 'forklift-safety-training',
        'slides' => [],
    ]);

    $response = $this->actingAs($this->consultant)
        ->getJson(route('dealer.search', ['q' => 'Forklift']))
        ->assertOk();

    $courses = collect($response->json('groups'))->firstWhere('key', 'courses');

    expect($courses)->not->toBeNull()
        ->and($courses['items'][0]['title'])->toBe('Forklift Safety Training');
});

it('finds tenant documents by title', function (): void {
    DealerDoc::query()->create([
        'title' => 'Emergency Evacuation Plan',
        'store_id' => Store::query()->value('id'),
    ]);

    $response = $this->actingAs($this->consultant)
        ->getJson(route('dealer.search', ['q' => 'Evacuation']))
        ->assertOk();

    $documents = collect($response->json('groups'))->firstWhere('key', 'documents');

    expect($documents)->not->toBeNull()
        ->and($documents['items'][0]['title'])->toBe('Emergency Evacuation Plan');
});
