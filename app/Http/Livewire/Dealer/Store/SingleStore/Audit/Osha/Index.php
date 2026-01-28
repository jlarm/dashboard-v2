<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Store\SingleStore\Audit\Osha;

use App\Models\Dealer\Audit\OshaAudit;
use App\Models\Dealer\Store;
use Livewire\Component;

class Index extends Component
{
    public Store $store;
    protected $listeners = ['refreshAudits' => '$refresh'];

    public function render()
    {
        $query = OshaAudit::where('store_id', $this->store->id)->orderBy('created_at', 'desc');

        if (auth()->user()->hasRole('Manager')) {
            $query->whereNot('pdf_path', null);
        }

        return view('livewire.dealer.store.single-store.audit.osha.index', [
            'oshaAudits' => $query->get(),
        ])->layout('components.dealer-app');
    }
}
