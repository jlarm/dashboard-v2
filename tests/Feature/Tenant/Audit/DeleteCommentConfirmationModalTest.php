<?php

declare(strict_types=1);

use App\Http\Livewire\Dealer\Audit\Components\DeleteCommentConfirmationModal;
use App\Models\AuditComment;
use App\Models\Dealer\Store;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function (): void {
    $this->actingAs($this->consultant);

    $this->comment = AuditComment::query()->create([
        'user_id' => $this->consultant->id,
        'auditable_id' => 1,
        'auditable_type' => Store::class,
        'comment' => 'Test comment',
    ]);
});

it('renders without error', function (): void {
    Livewire::test(DeleteCommentConfirmationModal::class, ['comment' => $this->comment])
        ->assertStatus(200);
});

it('has confirmationCaller initialized so actionConfirmed does not throw before confirmation flow', function (): void {
    $component = Livewire::test(DeleteCommentConfirmationModal::class, ['comment' => $this->comment]);

    expect($component->get('confirmationCaller'))->toBe('');
});

it('opens a confirmation modal when delete is called', function (): void {
    Livewire::test(DeleteCommentConfirmationModal::class, ['comment' => $this->comment])
        ->call('delete')
        ->assertEmitted('modal.open');
});

it('deletes the comment and emits commentDeleted after confirmation', function (): void {
    $commentId = $this->comment->id;

    Livewire::test(DeleteCommentConfirmationModal::class, ['comment' => $this->comment])
        ->set('actionConfirmed', true)
        ->set('confirmationCaller', 'delete')
        ->call('delete')
        ->assertEmitted('commentDeleted');

    expect(AuditComment::query()->find($commentId))->toBeNull();
});

it('prevents a different user from deleting the comment', function (): void {
    $otherUser = User::factory()->create();
    $this->actingAs($otherUser);

    Livewire::test(DeleteCommentConfirmationModal::class, ['comment' => $this->comment])
        ->set('actionConfirmed', true)
        ->set('confirmationCaller', 'delete')
        ->call('delete')
        ->assertForbidden();

    expect(AuditComment::query()->find($this->comment->id))->not->toBeNull();
});
