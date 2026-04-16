<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Audit\BodyShop;

use App\Models\Dealer\Audit\BodyShopViolationAudit;
use Filament\Notifications\Notification;
use WireElements\Pro\Components\Modal\Modal;

class Delete extends Modal
{
    public $bodyShopAudit;

    public function mount(BodyShopViolationAudit $bodyShopAudit): void
    {
        $this->bodyShopAudit = $bodyShopAudit;
    }

    public function delete(): void
    {
        $this->deleteViolationPhotos();

        $this->bodyShopAudit->delete();

        $this->emitTo('dealer.audit.body-shop.index', 'refreshAudits');

        $this->close();

        Notification::make()
            ->title('Body Shop Audit Deleted Successfully!')
            ->success()
            ->send();
    }

    public function render()
    {
        return view('livewire.dealer.audit.body-shop.delete');
    }

    protected function deleteViolationPhotos(): void
    {
        $this->bodyShopAudit->violations->each(function ($violation): void {
            $violation->clearMediaCollection('violations_files_0');
            $violation->clearMediaCollection('violations_files_1');
            $violation->clearMediaCollection('violations_files_2');
        });
    }
}
