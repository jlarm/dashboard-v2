<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Audit\Components;

use App\Models\AuditComment;
use Illuminate\View\View;
use WireElements\Pro\Components\Modal\Modal;
use WireElements\Pro\Concerns\InteractsWithConfirmationModal;

class DeleteCommentConfirmationModal extends Modal
{
    use InteractsWithConfirmationModal;

    public AuditComment $comment;

    public function mount(AuditComment $comment): void
    {
        $this->comment = $comment;
        $this->confirmationCaller = '';
    }

    public function delete(): void
    {
        abort_if($this->comment->user_id !== auth()->id(), 403);

        $this->askForConfirmation(
            callback: function (): void {
                $this->comment->delete();
                $this->emit('commentDeleted');
            },
            prompt: [
                'title' => 'Are you sure you want to delete this comment?',
                'message' => '',
                'confirm' => __('Yes'),
                'cancel' => __('Cancel'),
            ]
        );
    }

    public function render(): View
    {
        return view('livewire.dealer.audit.components.delete-comment-confirmation-modal');
    }
}
