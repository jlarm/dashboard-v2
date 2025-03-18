<?php

namespace App\Http\Livewire\Dealer\Audit\Finance;

use App\Models\Dealer\Audit\GlbaViolationAudit;
use App\Traits\HasGlbaViolationStatements;
use Filament\Notifications\Notification;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\MediaLibraryPro\Http\Livewire\Concerns\WithMedia;
use WireElements\Pro\Concerns\InteractsWithConfirmationModal;

class Edit extends Component
{
    use HasGlbaViolationStatements, InteractsWithConfirmationModal, WithFileUploads, WithMedia;

    public GlbaViolationAudit $glbaViolationAudit;

    public $store;

    public $violationStatements = [];

    public $violations;

    public $date;

    public $violationFiles = [];

    protected $listeners = [
        'violationSelected',
    ];

    protected $rules = [
        'violations.*.comment' => 'required',
        'violations.*.violation_date' => 'nullable|date',
        'violations.*.risk' => 'nullable|boolean',
        'violationFiles.*.*' => 'nullable|mimes:jpg,jpeg|max:5120',
    ];

    public function mount(): void
    {
        $glbaAudit = $this->glbaViolationAudit;
        $this->violations = $glbaAudit->violations()->get();
        $this->date = $glbaAudit->date->format('Y-m-d');
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
                if ($violation->id == $index) {
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
        } catch (\Exception $e) {
            Notification::make()
                ->title('Error updating audit')
                ->body('All violations must have a comment')
                ->danger()
                ->send();
        }
    }

    public function render()
    {
        return view('livewire.dealer.audit.finance.edit')->layout('components.dealer-app');
    }
}
