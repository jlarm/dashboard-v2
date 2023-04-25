<?php

namespace App\Http\Livewire\Dealer\Audit\Osha;

use App\Models\Dealer\Audit\OshaAudit;
use Livewire\Component;

class IndexItem extends Component
{
    public OshaAudit $audit;
    public function render()
    {
        return view('livewire.dealer.audit.osha.index-item');
    }
}
