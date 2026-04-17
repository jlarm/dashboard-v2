<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Audit\BodyShop;

use App\Models\Dealer\Audit\BodyShopAudit;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class GeneratedReportIndex extends Component
{
    public function render(): Factory|View
    {
        return view('livewire.dealer.audit.body-shop.generated-report-index', [
            'bodyShopAudits' => BodyShopAudit::query()->whereNot('pdf_path', '')->latest('audit_date')->select('id', 'audit_date', 'pdf_path')->get(),
        ]);
    }
}
