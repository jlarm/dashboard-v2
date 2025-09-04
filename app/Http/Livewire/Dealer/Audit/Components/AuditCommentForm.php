<?php

namespace App\Http\Livewire\Dealer\Audit\Components;

use App\Models\AuditComment;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\MediaLibraryPro\Http\Livewire\Concerns\WithMedia;

class AuditCommentForm extends Component
{
    use WithMedia, WithFileUploads;

    public int $auditId;
    public string $auditType;
    public string $comment = '';
    public $mediaComponentNames = ['images'];
    public $image;
    public bool $showForm = false;

    protected $rules = [
        'comment' => 'required|string|max:1000',
    ];

    public function mount($auditId, $auditType): void
    {
        $this->auditId = $auditId;
        $this->auditType = $auditType;
    }

    public function toggleForm(): void
    {
        $this->showForm = !$this->showForm;
    }

    public function submitComment(): void
    {
        $this->validate();

        $auditComment = AuditComment::create([
            'user_id' => auth()->id(),
            'auditable_id' => $this->auditId,
            'auditable_type' => $this->auditType,
            'comment' => $this->comment,
        ]);

        if ($this->image) {
            $auditComment->addMedia($this->image->getRealPath())
                ->toMediaCollection('comments', 'armpaudits');
        }

        $this->emit('commentAdded');
        $this->reset(['comment', 'image', 'showForm']);
        $this->clearMedia();
    }

    public function render(): View
    {
        return view('livewire.dealer.audit.components.audit-comment-form');
    }
}
