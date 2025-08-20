<?php

namespace App\Http\Livewire\Dealer\Audit\BodyShop;

use App\Models\Dealer\Audit\BodyShopViolationAudit;
use App\Traits\HasBodyShopViolationStatements;
use Filament\Notifications\Notification;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\MediaLibraryPro\Http\Livewire\Concerns\WithMedia;
use WireElements\Pro\Concerns\InteractsWithConfirmationModal;

class Edit extends Component
{
    use HasBodyShopViolationStatements, InteractsWithConfirmationModal, WithFileUploads, WithMedia;

    public BodyShopViolationAudit $bodyShopViolationAudit;

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
    ];

    public function mount(): void
    {
        $bodyShopAudit = $this->bodyShopViolationAudit;
        $this->violations = $bodyShopAudit->violations()->get();
        $this->date = $bodyShopAudit->date->format('Y-m-d');
        $this->checkInvalidViolations();
    }

    public function edit(): void
    {
        try {
            $this->validate();

            $this->bodyShopViolationAudit->update([
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

            $this->violations = $this->bodyShopViolationAudit->violations()->get();

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

    public function updated($propertyName): void
    {
        if (str_contains($propertyName, 'violations.') && str_contains($propertyName, '.comment')) {
            $this->checkInvalidViolations();
        }
    }

    public function render(): View
    {
        return view('livewire.dealer.audit.body-shop.edit')->layout('components.dealer-app');
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
