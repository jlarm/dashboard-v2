<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Store\SingleStore\Audit\BodyShop;

use App\Models\Dealer\Audit\BodyShopAudit;
use App\Models\Dealer\Store;
use Livewire\Component;

class Index extends Component
{
    public Store $store;
    protected $listeners = ['refreshStoreBodyShopAudits' => '$refresh'];

    public function render()
    {
        $query = BodyShopAudit::where('store_id', $this->store->id)->orderBy('created_at', 'desc');

        if (auth()->user()->hasRole('Manager')) {
            $query->whereNot('pdf_path', null);
        }

        return view('livewire.dealer.store.single-store.audit.body-shop.index', [
            'bodyShopAudits' => $query->get(),
        ])->layout('components.dealer-app');
    }
}
