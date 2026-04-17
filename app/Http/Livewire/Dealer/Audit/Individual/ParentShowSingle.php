<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Audit\Individual;

use App\Models\Dealer\Audit\IndividualAudit;
use App\Models\Dealer\Store;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Override;

class ParentShowSingle extends Component
{
    public IndividualAudit $individualAudit;
    public Store $store;
    public $children;

    #[Override]
    protected $listeners = ['refreshParentComponent' => '$refresh'];

    public function mount(): void
    {
        $this->children = $this->individualAudit->where('parent_id', $this->individualAudit->id)->count();
    }

    public function delete()
    {
        $this->individualAudit->delete();

        return to_route('dealer.audit.individual.index');
    }

    public function render(): Factory|View
    {
        return view('livewire.dealer.audit.individual.parent-show-single');
    }
}
