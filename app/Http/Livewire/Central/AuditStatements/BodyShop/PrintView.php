<?php

namespace App\Http\Livewire\Central\AuditStatements\BodyShop;

use App\Models\BodyShopViolationStatement;
use Livewire\Component;

class PrintView extends Component
{
    public function render()
    {
        return view('livewire.central.audit-statements.body-shop.print-view', [
            'violations' => BodyShopViolationStatement::all(),
        ])->layout('layouts.guest');
    }
}
