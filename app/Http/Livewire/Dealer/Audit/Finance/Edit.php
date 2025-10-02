<?php

namespace App\Http\Livewire\Dealer\Audit\Finance;

use App\Models\AuditComment;
use App\Models\Dealer\Audit\GlbaViolationAudit;
use App\Traits\HasGlbaViolationStatements;
use Exception;
use Filament\Notifications\Notification;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\MediaLibraryPro\Http\Livewire\Concerns\WithMedia;
use WireElements\Pro\Concerns\InteractsWithConfirmationModal;

class Edit extends Component
{
    use HasGlbaViolationStatements, InteractsWithConfirmationModal, WithFileUploads, WithMedia;

    public $date;
    public $store;
    public $violations;
    public $violationFiles = [];
    public Collection $comments;
    public $violationStatements = [];
    public bool $hasInvalidViolations = false;
    public GlbaViolationAudit $glbaViolationAudit;
    protected $listeners = [
        'commentAdded' => 'refreshComments',
        'commentDeleted' => 'refreshComments',
        'violationSelected',
    ];
    protected $rules = [
        'violations.*.comment' => 'required',
        'violations.*.violation_date' => 'nullable|date',
        'violations.*.risk' => 'nullable|boolean',
    ];

    public function mount(): void
    {
        $glbaAudit = $this->glbaViolationAudit;
        $this->violations = $glbaAudit->violations()->get();
        $this->date = $glbaAudit->date->format('Y-m-d');
        $this->checkInvalidViolations();
        $this->comments = $this->glbaViolationAudit->auditComments()->with('user')->latest()->get();
    }

    public function edit(): void
    {
        try {
            $this->validate();

            $this->glbaViolationAudit->update([
                'date' => $this->date,
            ]);

            foreach ($this->violations as $violation) {
                $data = [
                    'comment' => $violation['comment'],
                    'violation_date' => $violation['violation_date'],
                    'risk' => $violation['risk'],
                ];

                foreach ($this->violationFiles as $index => $files) {
                    if ($violation->id === $index) {
                        foreach ($files as $id => $file) {
                            $violation->addMedia($file->getRealPath())
                                ->toMediaCollection('violation_files_'.$id, 'armpaudits');
                        }
                    }
                }

                $violation->update($data);
            }

            $this->violationFiles = [];

            $this->violations = $this->glbaViolationAudit->violations()->get();

            Notification::make()
                ->title('Audit Updated!')
                ->success()
                ->send();
        } catch (Exception $e) {
            Notification::make()
                ->title('Error updating audit')
                ->body('All violations must have a comment')
                ->danger()
                ->send();
        }
    }

    public function updated($propertyName): void
    {
        if (str_contains($propertyName, 'violations.') && str_contains($propertyName, '.comment')) {
            $this->checkInvalidViolations();
        }
    }

    public function refreshComments(): void
    {
        $this->comments = $this->glbaViolationAudit->auditComments()->with('user')->latest()->get();
    }

    public function deleteComment($commentId): void
    {
        $comment = AuditComment::findOrFail($commentId);

        if ($comment->user_id !== auth()->id()) {
            Notification::make()
                ->title('You cannot delete this comment')
                ->warning()
                ->send();
        }

        $comment->delete();

        $this->emit('commentDeleted');
    }

    public function render(): View
    {
        return view('livewire.dealer.audit.finance.edit')
            ->layout('components.dealer-app');
    }

    private function checkInvalidViolations(): void
    {
        $this->hasInvalidViolations = false;

        foreach ($this->violations as $violation) {
            $comment = $violation['comment'] ?? '';
            if (mb_trim($comment) === '' || mb_trim($comment) === '0') {
                $this->hasInvalidViolations = true;
                break;
            }
        }
    }
}
