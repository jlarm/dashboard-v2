<?php

namespace App\Http\Livewire\Dealer\Audit\BodyShop;

use App\Models\Dealer\Audit\BodyShopViolationAudit;
use App\Models\Dealer\Store;
use Filament\Notifications\Notification;
use Illuminate\View\View;
use Livewire\Component;
use Storage;

class IndexItem extends Component
{
    public BodyShopViolationAudit $bodyShopAudit;
    public Store $store;
    public bool $remediations;
    protected $listeners = [
        'pdfGenerated' => '$refresh',
    ];

    public function mount(): void
    {
        $this->store = Store::find(app('currentStore'));
        $this->remediations = $this->store->remediations;
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
        return $this->bodyShopAudit->violation_count === 0 ? 0 : round($this->bodyShopAudit->remediation_count / $this->bodyShopAudit->violation_count * 100);
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
        $this->bodyShopAudit->violations->each(function ($violation) {
            $violation->clearMediaCollection('violations_files_0');
            $violation->clearMediaCollection('violations_files_1');
            $violation->clearMediaCollection('violations_files_2');
        });
    }
}
