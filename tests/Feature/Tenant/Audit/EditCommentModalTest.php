<?php

declare(strict_types=1);

use App\Http\Livewire\Dealer\Audit\Components\EditCommentModal;
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
        'comment' => 'Original comment',
    ]);
});

it('renders without error', function (): void {
    Livewire::test(EditCommentModal::class, ['commentId' => $this->comment->id])
        ->assertStatus(200);
});

it('populates commentText with the existing comment on mount', function (): void {
    Livewire::test(EditCommentModal::class, ['commentId' => $this->comment->id])
        ->assertSet('commentText', 'Original comment');
});

it('updates the comment text when edit is called', function (): void {
    Livewire::test(EditCommentModal::class, ['commentId' => $this->comment->id])
        ->set('commentText', 'Updated comment')
        ->call('edit');

    expect($this->comment->fresh()->comment)->toBe('Updated comment');
});

it('emits commentUpdated after a successful edit', function (): void {
    Livewire::test(EditCommentModal::class, ['commentId' => $this->comment->id])
        ->set('commentText', 'Updated comment')
        ->call('edit')
        ->assertEmitted('commentUpdated');
});

it('closes the modal after a successful edit', function (): void {
    Livewire::test(EditCommentModal::class, ['commentId' => $this->comment->id])
        ->set('commentText', 'Updated comment')
        ->call('edit')
        ->assertEmitted('modal.close');
});

it('requires commentText to not be empty', function (): void {
    Livewire::test(EditCommentModal::class, ['commentId' => $this->comment->id])
        ->set('commentText', '')
        ->call('edit')
        ->assertHasErrors(['commentText' => 'required']);

    expect($this->comment->fresh()->comment)->toBe('Original comment');
});

it('prevents a different user from editing the comment', function (): void {
    $otherUser = User::factory()->create();
    $this->actingAs($otherUser);

    Livewire::test(EditCommentModal::class, ['commentId' => $this->comment->id])
        ->set('commentText', 'Hijacked comment')
        ->call('edit')
        ->assertForbidden();

    expect($this->comment->fresh()->comment)->toBe('Original comment');
});
