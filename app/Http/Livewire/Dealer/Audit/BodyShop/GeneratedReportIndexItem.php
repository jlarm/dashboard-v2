<?php

namespace App\Http\Livewire\Dealer\Audit\BodyShop;

use App\Models\Dealer\Audit\BodyShopAudit;
use App\Models\Dealer\Store;
use Livewire\Component;

class GeneratedReportIndexItem extends Component
{
    public BodyShopAudit $bodyShopAudit;

    public Store $store;

    public $rating;

    public $audits;

    protected $sum;

    public function mount()
    {
        $this->audits = BodyShopAudit::where('id', $this->bodyShopAudit->id)->get();
        $this->audits->filter(function ($value) {
            for ($i = 1; $i <= 43; $i++) {
                if ($value->{'body_shop_q'.$i.'_answer'} == 2) {
                    $this->sum += 1;
                }
            }
        });
        $total = count($this->audits) * 43;
        $wrong = $this->sum;
        $this->rating = number_format(100 * ($total - $wrong) / $total, 2, '.', '');
    }

    public function render()
    {
        return view('livewire.dealer.audit.body-shop.generated-report-index-item');
    }
}
