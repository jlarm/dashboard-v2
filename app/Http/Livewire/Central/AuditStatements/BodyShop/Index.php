<?php

namespace App\Http\Livewire\Central\AuditStatements\BodyShop;

use App\Models\BodyShopViolationStatement;
use Illuminate\View\View;
use Livewire\Component;

class Index extends Component
{
    public function render(): View
    {
        return view('livewire.central.audit-statements.body-shop.index', [
            'violations' => BodyShopViolationStatement::orderBy('statement')->paginate(20),
        ]);
    }
}
