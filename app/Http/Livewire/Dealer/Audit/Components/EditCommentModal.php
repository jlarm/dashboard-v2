<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Audit\Components;

use App\Models\AuditComment;
use Filament\Notifications\Notification;
use Illuminate\View\View;
use WireElements\Pro\Components\Modal\Modal;

class EditCommentModal extends Modal
{
    public AuditComment $comment;

    public string $commentText = '';

    public function mount(int $commentId): void
    {
        $this->comment = AuditComment::findOrFail($commentId);
        $this->commentText = $this->comment->comment;
    }

    public function edit(): void
    {
        abort_if($this->comment->user_id !== auth()->id(), 403);

        $this->validate(['commentText' => 'required|string']);

        $this->comment->update(['comment' => $this->commentText]);

        $this->emit('commentUpdated');
        $this->close();

        Notification::make()
            ->title('Comment Updated Successfully!')
            ->success()
            ->send();
    }

    public function render(): View
    {
        return view('livewire.dealer.audit.components.edit-comment-modal');
    }
}
