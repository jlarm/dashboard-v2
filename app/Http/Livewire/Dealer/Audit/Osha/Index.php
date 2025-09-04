<?php

namespace App\Http\Livewire\Dealer\Audit\Osha;

use App\Models\Dealer\Store;
use Illuminate\View\View;
use Livewire\Component;

class Index extends Component
{
    public $store;

    protected $listeners = [
        'refreshAudits' => '$refresh',
    ];

    public function mount(): void
    {
        $this->store = Store::with('oshaViolationAudits')->where('id', app('currentStore'))->firstOrFail();
    }

    public function render(): View
    {
        return view('livewire.dealer.audit.osha.index', [
            'oshaAudits' => $this->store->oshaAudits->sortByDesc('audit_date'),
            'audits' => $this->store->oshaViolationAudits->sortByDesc('date'),
        ])->layout('components.dealer-app');
    }
}
