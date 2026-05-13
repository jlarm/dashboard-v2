<?php

declare(strict_types=1);

use App\Models\Dealer\Store;
use App\Models\User;
use Spatie\Permission\Models\Role;

beforeEach(function (): void {
    $this->store = Store::query()->firstOrFail();
});

it('lets a Consultant save the consultant note for their selected store', function (): void {
    $this->consultant->update(['current_store_id' => $this->store->id]);

    $this->actingAs($this->consultant)
        ->post(route('dealer.dashboard.consultant-note.update'), [
            'note' => 'Audit findings to follow up next visit.',
        ])
        ->assertRedirect();

    expect($this->store->fresh()->note)->toBe('Audit findings to follow up next visit.');
});

it('persists null when the consultant clears the note', function (): void {
    $this->consultant->update(['current_store_id' => $this->store->id]);
    $this->store->update(['note' => 'existing note']);

    $this->actingAs($this->consultant)
        ->post(route('dealer.dashboard.consultant-note.update'), [
            'note' => '   ',
        ])
        ->assertRedirect();

    expect($this->store->fresh()->note)->toBeNull();
});

it('rejects non-consultant roles', function (): void {
    $manager = User::query()->create([
        'name' => 'Note Manager '.uniqid(),
        'email' => 'note-manager-'.uniqid().'@test.com',
        'password' => bcrypt('password'),
    ]);
    $manager->assignRole(Role::query()->where('name', 'Manager')->firstOrFail());
    $manager->stores()->attach($this->store->id);
    $manager->update(['current_store_id' => $this->store->id]);

    $this->actingAs($manager)
        ->post(route('dealer.dashboard.consultant-note.update'), [
            'note' => 'sneaky',
        ])
        ->assertForbidden();

    expect($this->store->fresh()->note)->toBeNull();
});

it('caps the note length at 5000 characters', function (): void {
    $this->consultant->update(['current_store_id' => $this->store->id]);

    $this->actingAs($this->consultant)
        ->post(route('dealer.dashboard.consultant-note.update'), [
            'note' => str_repeat('a', 5001),
        ])
        ->assertSessionHasErrors(['note']);
});
