<?php

namespace App\Http\Livewire\Dealer\Home;

use App\Models\Dealer\Audit\OshaAudit;
use App\Models\Dealer\Store;
use App\Traits\OshaGenerateRating;
use Carbon\Carbon;
use Livewire\Component;

class OshaStats extends Component
{
    use OshaGenerateRating;

    public ?float $rating;
    public Store $store;
    public $audits;
    public $dates;

    public function mount()
    {
        $this->store = $this->store ?? Store::first();

        $this->rating = OshaAudit::where('store_id', $this->store->id)->pluck('rating')->average();
        
        $this->audits = OshaAudit::query()
            ->where('store_id', $this->store->id)
            ->where('pdf_path', '!=', null)
            ->where('audit_date', '>=', Carbon::now()->subYears(2))
            ->orderBy('audit_date', 'desc')
            ->pluck('rating')
            ->values()
            ->toArray();

        $this->dates = OshaAudit::query()
            ->where('store_id', $this->store->id)
            ->where('pdf_path', '!=', null)
            ->where('audit_date', '>=', Carbon::now()->subYears(2))
            ->selectRaw('DATE_FORMAT(audit_date, "%Y-%m-%d") as date')
            ->orderBy('date', 'desc')
            ->groupBy('date')
            ->pluck('date')
            ->values()
            ->toArray();
    }

    public function render()
    {
        return view('livewire.dealer.home.osha-stats');
    }
}
