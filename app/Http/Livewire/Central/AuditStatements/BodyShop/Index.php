<?php

namespace App\Http\Livewire\Central\AuditStatements\BodyShop;

use App\Models\BodyShopViolationStatement;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.central.audit-statements.body-shop.index', [
            'violations' => BodyShopViolationStatement::orderBy('statement')->paginate(20),
        ]);
    }
}
