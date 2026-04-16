<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Audit\BodyShop;

use App\Models\Dealer\Audit\BodyShopAudit;
use App\Models\Dealer\Store;
use Illuminate\View\View;
use Livewire\Component;

class GeneratedReportIndexItem extends Component
{
    public BodyShopAudit $bodyShopAudit;
    public Store $store;
    public string $rating = '';

    public function mount(): void
    {
        $sum = 0;
        $total = 43;

        for ($i = 1; $i <= $total; $i++) {
            if ($this->bodyShopAudit->{'body_shop_q'.$i.'_answer'} === 2) {
                $sum++;
            }
        }

        $this->rating = number_format(100 * ($total - $sum) / $total, 2, '.', '');
    }

    public function render(): View
    {
        return view('livewire.dealer.audit.body-shop.generated-report-index-item');
    }
}
