<?php

namespace App\Http\Livewire\Dealer\Audit\Components;

use App\Models\AuditComment;
use Illuminate\View\View;
use WireElements\Pro\Components\Modal\Modal;
use WireElements\Pro\Concerns\InteractsWithConfirmationModal;

class DeleteCommentConfirmationModal extends Modal
{
    use InteractsWithConfirmationModal;

    public AuditComment $comment;

    public function delete(): void
    {
        $this->askForConfirmation(
            callback: function () {
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
