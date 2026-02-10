<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Audit\BodyShop;

use App\Models\Dealer\Audit\BodyShopViolationAudit;
use App\Models\Dealer\Store;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Livewire\Component;

class IndexItem extends Component
{
    public BodyShopViolationAudit $bodyShopAudit;
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
        $this->store = Store::query()->find(app('currentStore'));
        $this->remediations = (bool) $this->store->remediations;
        $this->grade = $this->bodyShopAudit->grade ?? '';
    }

    public function toggleGradeEdit(): void
    {
        $this->editingGrade = ! $this->editingGrade;
        $this->grade = $this->bodyShopAudit->grade ?? '';
    }

    public function saveGrade(): void
    {
        abort_unless(auth()->user()->hasAnyRole(['super-admin', 'Consultant']), 403);

        $this->validate();

        $this->bodyShopAudit->update([
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
        return $this->bodyShopAudit->date->format('Y').' Q'.ceil($this->bodyShopAudit->date->format('n') / 3);
    }

    public function download()
    {
        return Storage::disk('armpaudits')->download($this->bodyShopAudit->pdf_path);
    }

    public function remediationsActive(): bool
    {
        return $this->store->remediationSettings !== null && $this->store->remediationSettings->exists() && $this->store->remediationSettings->first()->active;
    }

    public function remediationProgress(): int
    {
        return $this->bodyShopAudit->violation_count === 0 ? 0 : (int) round($this->bodyShopAudit->remediation_count / $this->bodyShopAudit->violation_count * 100);
    }

    public function commentCount(): int
    {
        return $this->bodyShopAudit->auditComments()->count();
    }

    public function delete(): void
    {
        $this->deleteViolationPhotos();
        $this->bodyShopAudit->delete();

        $this->emitTo('dealer.audit.body-shop.index', 'refreshAudits');

        Notification::make()
            ->title('Body Shop Audit Deleted Successfully!')
            ->success()
            ->send();
    }

    public function render(): View
    {
        return view('livewire.dealer.audit.body-shop.index-item');
    }

    private function deleteViolationPhotos(): void
    {
        $this->bodyShopAudit->violations->each(function ($violation): void {
            $violation->clearMediaCollection('violations_files_0');
            $violation->clearMediaCollection('violations_files_1');
            $violation->clearMediaCollection('violations_files_2');
        });
    }
}
