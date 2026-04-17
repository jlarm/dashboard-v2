<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Audit\Individual;

use App\Models\Dealer\Audit\IndividualAudit;
use App\Models\Dealer\Store;
use Illuminate\View\View;
use Livewire\Component;
use Override;

class IndexItem extends Component
{
    public IndividualAudit $individualAudit;
    public Store $store;
    public bool $tenants;
    public $rating;

    #[Override]
    protected $listeners = [
        'refreshIndividualAudits' => '$refresh',
    ];

    public function mount(): void
    {
        $this->individualAudit->loadMissing('children');
        $this->tenants = resolve('multipleStoresExist');

        $flat = collect([$this->individualAudit, $this->individualAudit->children])->flatten();
        $ratings = $flat->pluck('rating');

        $this->rating = $ratings->contains(null) ? 0 : $ratings->avg();
    }

    public function getQuarterNameAttribute(): ?string
    {
        $month = (int) $this->individualAudit->audit_date->format('n');

        return match (true) {
            $month <= 3 => 'Q1',
            $month <= 6 => 'Q2',
            $month <= 9 => 'Q3',
            default => 'Q4',
        };
    }

    public function render(): View
    {
        return view('livewire.dealer.audit.individual.index-item');
    }
}
