<?php

namespace App\Http\Livewire\Dealer\Home;

use App\Models\Dealer\Audit\BodyShopAudit;
use App\Traits\BodyShopGenerateRating;
use Carbon\Carbon;
use Livewire\Component;

class BodyShopStats extends Component
{
    use BodyShopGenerateRating;

    public ?float $rating;
    public $audits;
    public $dates;

    public function mount()
    {
        $this->rating = $this->rating();
        $this->audits = cache()->remember('body_shop_rating', 60*60*24, function () {
            return BodyShopAudit::where('audit_date', '>=', Carbon::now()->subYears(2))
                ->where('pdf_path', '!=', null)
                ->orderBy('audit_date', 'desc')
                ->pluck('rating')
                ->values()
                ->toArray();
        });
        $this->dates = cache()->remember('body_shop_dates', 60*60*24, function () {
            return BodyShopAudit::query()
                ->where('audit_date', '>=', Carbon::now()->subYears(2))
                ->where('pdf_path', '!=', null)
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
        return view('livewire.dealer.home.body-shop-stats');
    }
}
