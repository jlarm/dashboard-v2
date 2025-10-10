<?php

declare(strict_types=1);

use App\Http\Livewire\Central\Event\Create;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('component can render', function (): void {
    Livewire::test(Create::class)
        ->assertStatus(200);
});

test('can create event with required fields only', function (): void {
    Livewire::test(Create::class)
        ->set('name', 'Laravel Conference 2025')
        ->set('startDate', '2025-06-01')
        ->set('endDate', '2025-06-03')
        ->call('create')
        ->assertEmitted('eventAdded');

    $this->assertDatabaseHas('events', [
        'name' => 'Laravel Conference 2025',
        'start_date' => '2025-06-01',
        'end_date' => '2025-06-03',
    ]);
});

test('can create event with all fields', function (): void {
    Livewire::test(Create::class)
        ->set('name', 'Laravel Conference 2025')
        ->set('startDate', '2025-06-01')
        ->set('endDate', '2025-06-03')
        ->set('locationName', 'Convention Center')
        ->set('address', '123 Main St')
        ->set('city', 'San Francisco')
        ->set('state', 'CA')
        ->set('zipCode', '94102')
        ->set('link', 'https://laravel.com/conference')
        ->call('create')
        ->assertEmitted('eventAdded');

    $this->assertDatabaseHas('events', [
        'name' => 'Laravel Conference 2025',
        'start_date' => '2025-06-01',
        'end_date' => '2025-06-03',
        'location_name' => 'Convention Center',
        'address' => '123 Main St',
        'city' => 'San Francisco',
        'state' => 'CA',
        'zip_code' => '94102',
        'link' => 'https://laravel.com/conference',
    ]);
});

test('name is required', function (): void {
    Livewire::test(Create::class)
        ->set('name', '')
        ->set('startDate', '2025-06-01')
        ->set('endDate', '2025-06-03')
        ->call('create')
        ->assertHasErrors(['name' => 'required']);

    $this->assertDatabaseCount('events', 0);
});

test('start date is required', function (): void {
    Livewire::test(Create::class)
        ->set('name', 'Laravel Conference 2025')
        ->set('startDate', '')
        ->set('endDate', '2025-06-03')
        ->call('create')
        ->assertHasErrors(['startDate' => 'required']);

    $this->assertDatabaseCount('events', 0);
});

test('end date is required', function (): void {
    Livewire::test(Create::class)
        ->set('name', 'Laravel Conference 2025')
        ->set('startDate', '2025-06-01')
        ->set('endDate', '')
        ->call('create')
        ->assertHasErrors(['endDate' => 'required']);

    $this->assertDatabaseCount('events', 0);
});

test('end date must be after or equal to start date', function (): void {
    Livewire::test(Create::class)
        ->set('name', 'Laravel Conference 2025')
        ->set('startDate', '2025-06-03')
        ->set('endDate', '2025-06-01')
        ->call('create')
        ->assertHasErrors(['endDate' => 'after_or_equal']);

    $this->assertDatabaseCount('events', 0);
});

test('end date can be same as start date', function (): void {
    Livewire::test(Create::class)
        ->set('name', 'One Day Workshop')
        ->set('startDate', '2025-06-01')
        ->set('endDate', '2025-06-01')
        ->call('create')
        ->assertHasNoErrors()
        ->assertEmitted('eventAdded');

    $this->assertDatabaseHas('events', [
        'name' => 'One Day Workshop',
        'start_date' => '2025-06-01',
        'end_date' => '2025-06-01',
    ]);
});

test('name cannot exceed 255 characters', function (): void {
    $longName = str_repeat('a', 256);

    Livewire::test(Create::class)
        ->set('name', $longName)
        ->set('startDate', '2025-06-01')
        ->set('endDate', '2025-06-03')
        ->call('create')
        ->assertHasErrors(['name' => 'max']);

    $this->assertDatabaseCount('events', 0);
});
