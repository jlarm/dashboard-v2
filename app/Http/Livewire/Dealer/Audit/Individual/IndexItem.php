<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Audit\Individual;

use App\Models\Dealer\Audit\IndividualAudit;
use App\Models\Dealer\Store;
use Illuminate\View\View;
use Livewire\Component;

class IndexItem extends Component
{
    public IndividualAudit $individualAudit;
    public Store $store;
    public $drafts;
    public $tenants;
    public $deals;
    public $sum;
    public $rating;
    public $flat;
    public $test;
    protected $listeners = [
        'refreshIndividualAudits' => '$refresh',
    ];

    public function mount(): void
    {
        $this->individualAudit->loadMissing('children');
        $combine = collect([$this->individualAudit, $this->individualAudit->children]);
        $this->flat = $combine->flatten();
        $this->tenants = tenant('locations');

        $this->test = $this->flat->pluck('rating');

        $this->rating = $this->test->contains(null) ? 0 : $this->test->avg();
    }

    public function getQuarterNameAttribute(): ?string
    {
        if ($this->individualAudit->audit_date->format('m') >= 1 && $this->individualAudit->audit_date->format('m') <= 3) {
            return 'Q1';
        }
        if ($this->individualAudit->audit_date->format('m') >= 4 && $this->individualAudit->audit_date->format('m') <= 6) {
            return 'Q2';
        }
        if ($this->individualAudit->audit_date->format('m') >= 7 && $this->individualAudit->audit_date->format('m') <= 9) {
            return 'Q3';
        }
        if ($this->individualAudit->audit_date->format('m') >= 10 && $this->individualAudit->audit_date->format('m') <= 12) {
            return 'Q4';
        }
        return null;
    }

    public function render(): View
    {
        return view('livewire.dealer.audit.individual.index-item');
    }
}
