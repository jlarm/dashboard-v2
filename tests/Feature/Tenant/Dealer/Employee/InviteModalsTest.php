<?php

declare(strict_types=1);

use App\Http\Livewire\Dealer\Employee\DeleteInvite;
use App\Http\Livewire\Dealer\Employee\ResendInvite;
use App\Models\Dealer\Invite;
use Livewire\Livewire;

function createInvite(array $attributes = []): Invite
{
    return Invite::create(array_merge([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'roles' => ['Employee'],
        'stores' => [],
    ], $attributes));
}

describe('ResendInvite Modal', function () {
    it('renders when invite exists', function () {
        $invite = createInvite(['name' => 'John Doe', 'email' => 'john@example.com']);

        Livewire::actingAs($this->consultant)
            ->test(ResendInvite::class, ['inviteId' => $invite->id])
            ->assertStatus(200)
            ->assertSet('invite.id', $invite->id);
    });

    it('does not throw exception when invite does not exist', function () {
        $nonExistentId = 99999;

        $component = Livewire::actingAs($this->consultant)
            ->test(ResendInvite::class, ['inviteId' => $nonExistentId]);

        expect($component->get('invite'))->toBeNull();
    });
});

describe('DeleteInvite Modal', function () {
    it('renders when invite exists', function () {
        $invite = createInvite(['name' => 'Jane Doe', 'email' => 'jane@example.com']);

        Livewire::actingAs($this->consultant)
            ->test(DeleteInvite::class, ['inviteId' => $invite->id])
            ->assertStatus(200)
            ->assertSet('invite.id', $invite->id);
    });

    it('does not throw exception when invite does not exist', function () {
        $nonExistentId = 99999;

        $component = Livewire::actingAs($this->consultant)
            ->test(DeleteInvite::class, ['inviteId' => $nonExistentId]);

        expect($component->get('invite'))->toBeNull();
    });

    it('deletes invite and emits refresh event', function () {
        $invite = createInvite(['name' => 'Delete Me', 'email' => 'delete@example.com']);

        Livewire::actingAs($this->consultant)
            ->test(DeleteInvite::class, ['inviteId' => $invite->id])
            ->call('deleteInvite')
            ->assertEmitted('refreshOpenInvites');

        expect(Invite::find($invite->id))->toBeNull();
    });

    it('handles delete gracefully when invite was already deleted', function () {
        $invite = createInvite(['name' => 'Already Gone', 'email' => 'gone@example.com']);
        $inviteId = $invite->id;

        // Delete the invite before the component can delete it
        $invite->delete();

        // Opening the modal with a deleted invite should not throw
        $component = Livewire::actingAs($this->consultant)
            ->test(DeleteInvite::class, ['inviteId' => $inviteId]);

        expect($component->get('invite'))->toBeNull();
    });
});
