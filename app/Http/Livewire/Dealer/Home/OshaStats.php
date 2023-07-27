<?php

namespace App\Http\Livewire\Dealer\Home;

use App\Models\Dealer\Audit\OshaAudit;
use App\Traits\OshaGenerateRating;
use Carbon\Carbon;
use Livewire\Component;

class OshaStats extends Component
{
    use OshaGenerateRating;

    public ?float $rating;
    public $audits;
    public $dates;

    public function mount()
    {
        $this->rating = $this->rating();
        $this->audits = cache()->remember('osha_rating', 60*60*24, function () {
            return OshaAudit::where('pdf_path', '!=', null)
                ->where('audit_date', '>=', Carbon::now()->subYears(2))
                ->orderBy('audit_date', 'desc')
                ->pluck('rating')
                ->values()
                ->toArray();
        });
        $this->dates = cache()->remember('osha_dates', 60*60*24, function () {
            return OshaAudit::query()
                ->where('pdf_path', '!=', null)
                ->where('audit_date', '>=', Carbon::now()->subYears(2))
                ->selectRaw('DATE_FORMAT(audit_date, "%Y-%m-%d") as date')
                ->orderBy('date', 'desc')
                ->groupBy('date')
                ->pluck('date')
                ->values()
                ->toArray();
        });
    }

    public function render()
    {
        return view('livewire.dealer.home.osha-stats');
    }
}
