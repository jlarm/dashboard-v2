<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Audit\BodyShop;

use Illuminate\Support\Facades\Storage;
use App\Models\Dealer\Audit\BodyShopAudit;
use Livewire\Component;

class OldAuditIndex extends Component
{
    public BodyShopAudit $bodyShopAudit;

    public function quarter(): string
    {
        return $this->bodyShopAudit->audit_date->format('Y').' Q'.ceil($this->bodyShopAudit->audit_date->format('n') / 3);
    }

    public function grade(): string
    {
        return match (true) {
            $this->bodyShopAudit->rating >= 90 => 'A',
            $this->bodyShopAudit->rating >= 80 => 'B',
            $this->bodyShopAudit->rating >= 70 => 'C',
            $this->bodyShopAudit->rating >= 60 => 'D',
            $this->bodyShopAudit->rating >= 50 => 'F',
            default => 'N/A',
        };
    }

    public function download()
    {
        return Storage::disk('do-audits')->download(tenant('id').'/body-shop/'.$this->bodyShopAudit->pdf_path);
    }

    public function render()
    {
        return view('livewire.dealer.audit.body-shop.old-audit-index');
    }
}
