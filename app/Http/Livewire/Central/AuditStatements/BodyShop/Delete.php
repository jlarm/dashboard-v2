<?php

namespace App\Http\Livewire\Central\AuditStatements\BodyShop;

use App\Models\BodyShopViolationStatement;
use Filament\Notifications\Notification;
use Illuminate\View\View;
use Livewire\Component;
use WireElements\Pro\Components\Modal\Modal;
use WireElements\Pro\Concerns\InteractsWithConfirmationModal;

class Delete extends Modal
{
    use InteractsWithConfirmationModal;
    public BodyShopViolationStatement $bodyShopViolationStatement;

    public function delete(): void
    {
        $this->askForConfirmation(
            callback: function () {
                $this->bodyShopViolationStatement->delete();

                Notification::make()
                    ->title('Statement Deleted Successfully!')
                    ->success()
                    ->send();

                redirect(route('body-shop-violations.index'));
            }
        );
    }

    public function render(): View
    {
        return view('livewire.central.audit-statements.body-shop.delete');
    }
}
