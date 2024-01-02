<?php

namespace App\Http\Livewire\Dealer\Home;

use App\Models\Dealer\Audit\BodyShopAudit;
use App\Models\Dealer\Store;
use App\Traits\BodyShopGenerateRating;
use Carbon\Carbon;
use Livewire\Component;

class BodyShopStats extends Component
{
    use BodyShopGenerateRating;

    public Store $store;

    public ?float $rating;

    public $audits;

    public $dates;

    public function mount()
    {
        $this->store = $this->store ?? Store::first();

        $this->rating = BodyShopAudit::where('store_id', $this->store->id)->pluck('rating')->average();

        $this->audits = BodyShopAudit::query()
            ->where('store_id', $this->store->id)
            ->where('audit_date', '>=', Carbon::now()->subYears(2))
            ->where('pdf_path', '!=', null)
            ->orderBy('audit_date', 'desc')
            ->pluck('rating')
            ->values()
            ->toArray();

        $this->dates = BodyShopAudit::query()
            ->where('store_id', $this->store->id)
            ->where('audit_date', '>=', Carbon::now()->subYears(2))
            ->where('pdf_path', '!=', null)
            ->selectRaw('DATE_FORMAT(audit_date, "%Y-%m-%d") as date')
            ->orderBy('date', 'desc')
            ->groupBy('date')
            ->pluck('date')
            ->values()
            ->toArray();
    }

    public function render()
    {
        return view('livewire.dealer.home.body-shop-stats');
    }
}
