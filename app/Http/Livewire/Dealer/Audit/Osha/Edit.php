<?php

namespace App\Http\Livewire\Dealer\Audit\Osha;

use App\Models\Dealer\Audit\OshaViolationAudit;
use App\Traits\HasOshaViolationStatements;
use Filament\Notifications\Notification;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\MediaLibraryPro\Http\Livewire\Concerns\WithMedia;
use WireElements\Pro\Concerns\InteractsWithConfirmationModal;

class Edit extends Component
{
    use HasOshaViolationStatements, InteractsWithConfirmationModal, WithFileUploads, WithMedia;

    public OshaViolationAudit $oshaViolationAudit;

    public $store;

    public $violationStatements = [];

    public $violations;

    public $date;

    public $violationFiles = [];

    public bool $hasInvalidViolations = false;

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
        $oshaAudit = $this->oshaViolationAudit;
        $this->violations = $oshaAudit->violations()->get();
        $this->date = $oshaAudit->date->format('Y-m-d');
        $this->checkInvalidViolations();
    }

    public function edit(): void
    {
        try {
            $this->validate();

            $this->oshaViolationAudit->update([
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
                            try {
                                \Log::info('Attempting to upload file', [
                                    'violation_id' => $violation->id,
                                    'file_id' => $id,
                                    'file_size' => $file->getSize(),
                                    'file_mime' => $file->getMimeType(),
                                    'file_name' => $file->getClientOriginalName(),
                                ]);

                                $violation->addMedia($file->getRealPath())
                                    ->toMediaCollection('violation_files_'.$id, 'armpaudits');
                            } catch (\Exception $uploadException) {
                                \Log::error('Error uploading file', [
                                    'violation_id' => $violation->id,
                                    'file_id' => $id,
                                    'error' => $uploadException->getMessage(),
                                    'trace' => $uploadException->getTraceAsString(),
                                ]);

                                throw $uploadException;
                            }
                        }
                    }
                }

                $violation->update($data);
            }

            $this->violationFiles = [];

            $this->violations = $this->oshaViolationAudit->violations()->get();

            Notification::make()
                ->title('Audit Updated!')
                ->success()
                ->send();
        } catch (\Exception $e) {
            \Log::error('Error updating audit', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            $errorMessage = 'All violations must have a comment';

            if (strpos($e->getMessage(), 'validation.max.file') !== false) {
                $errorMessage = 'One or more files exceeded the 5MB size limit';
            }

            Notification::make()
                ->title('Error updating audit')
                ->body($errorMessage)
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

    public function render(): View
    {
        return view('livewire.dealer.audit.osha.edit')->layout('components.dealer-app');
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
