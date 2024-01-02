<?php

namespace App\Http\Livewire\Dealer\Audit\BodyShop;

use App\Models\Dealer\Audit\BodyShopAudit;
use Livewire\Component;

class GeneratedReportIndex extends Component
{
    public function render()
    {
        return view('livewire.dealer.audit.body-shop.generated-report-index', [
            'bodyShopAudits' => BodyShopAudit::whereNot('pdf_path', '')->orderBy('audit_date', 'desc')->select('id', 'audit_date', 'pdf_path')->get(),
        ]);
    }
}
