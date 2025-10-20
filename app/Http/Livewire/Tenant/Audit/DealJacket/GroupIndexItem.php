<?php

declare(strict_types=1);

namespace App\Http\Livewire\Tenant\Audit\DealJacket;

use App\Models\Dealer\Audit\DealJacketGroup;
use Illuminate\View\View;
use Livewire\Component;

class GroupIndexItem extends Component
{
    public DealJacketGroup $dealJacketGroup;

    public function render(): View
    {
        return view('livewire.tenant.audit.deal-jacket.group-index-item');
    }
}
