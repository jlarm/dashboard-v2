<?php

namespace App\Http\Livewire\Dealer\Audit\BodyShop;

use App\Models\Dealer\Store;
use Livewire\Component;

class Index extends Component
{
    public $store;
    protected $listeners = [
        'refreshAudits' => '$refresh',
    ];

    public function mount()
    {
        $this->store = Store::with('bodyShopAudits')->where('id', app('currentStore'))->firstOrFail();
    }

    public function render()
    {
        return view('livewire.dealer.audit.body-shop.index', [
            'bodyShopAudits' => $this->store->bodyShopAudits->sortByDesc('audit_date'),
            'audits' => $this->store->bodyShopViolationAudits->sortByDesc('date'),
        ])->layout('components.dealer-app');
    }
}
