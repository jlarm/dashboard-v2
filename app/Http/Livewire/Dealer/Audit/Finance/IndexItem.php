<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Audit\Finance;

use App\Models\Dealer\Audit\GlbaViolationAudit;
use App\Models\Dealer\Store;
use Filament\Notifications\Notification;
use Illuminate\View\View;
use Livewire\Component;
use Storage;

class IndexItem extends Component
{
    public GlbaViolationAudit $glbaViolationAudit;
    public Store $store;
    public bool $remediations;
    public bool $editingGrade = false;
    public string $grade = '';
    protected $listeners = [
        'pdfGenerated' => '$refresh',
    ];
    protected $rules = [
        'grade' => 'required|in:A,B,C,D,F',
    ];

    public function mount(): void
    {
        $this->store = Store::find(app('currentStore'));
        $this->remediations = (bool) $this->store->remediations;
        $this->grade = $this->glbaViolationAudit->grade ?? '';
    }

    public function toggleGradeEdit(): void
    {
        $this->editingGrade = ! $this->editingGrade;
        $this->grade = $this->glbaViolationAudit->grade ?? '';
    }

    public function saveGrade(): void
    {
        if (! auth()->user()->hasAnyRole(['super-admin', 'Consultant'])) {
            abort(403);
        }

        $this->validate();

        $this->glbaViolationAudit->update([
            'grade' => $this->grade,
            'grade_updated_by' => auth()->id(),
            'grade_updated_at' => now(),
        ]);

        $this->editingGrade = false;

        Notification::make()
            ->title('Grade Updated Successfully!')
            ->success()
            ->send();
    }

    public function quarter(): string
    {
        return $this->glbaViolationAudit->date->format('Y').' Q'.ceil($this->glbaViolationAudit->date->format('n') / 3);
    }

    public function download()
    {
        return Storage::disk('armpaudits')->download($this->glbaViolationAudit->pdf_path);
    }

    public function remediationsActive(): bool
    {
        return $this->store->remediationSettings !== null && $this->store->remediationSettings->exists() && $this->store->remediationSettings->first()->active;
    }

    public function remediationProgress(): int
    {
        return $this->glbaViolationAudit->violation_count === 0 ? 0 : round($this->glbaViolationAudit->remediation_count / $this->glbaViolationAudit->violation_count * 100);
    }

    public function delete(): void
    {
        $this->deleteViolationPhotos();
        $this->glbaViolationAudit->delete();

        $this->emitTo('dealer.audit.finance.index', 'refreshAudits');

        Notification::make()
            ->title('GLBA Audit Deleted Successfully!')
            ->success()
            ->send();
    }

    public function render(): View
    {
        return view('livewire.dealer.audit.finance.index-item');
    }

    private function deleteViolationPhotos(): void
    {
        $this->glbaViolationAudit->violations->each(function ($violation) {
            $violation->clearMediaCollection('violations_files_0');
            $violation->clearMediaCollection('violations_files_1');
            $violation->clearMediaCollection('violations_files_2');
        });
    }
}
