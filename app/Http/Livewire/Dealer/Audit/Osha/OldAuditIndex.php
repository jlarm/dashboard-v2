<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Audit\Osha;

use App\Models\Dealer\Audit\OshaAudit;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class OldAuditIndex extends Component
{
    public OshaAudit $oshaAudit;

    public function quarter(): string
    {
        return $this->oshaAudit->audit_date->format('Y').' Q'.ceil($this->oshaAudit->audit_date->format('n') / 3);
    }

    public function grade(): string
    {
        return match (true) {
            $this->oshaAudit->rating >= 90 => 'A',
            $this->oshaAudit->rating >= 80 => 'B',
            $this->oshaAudit->rating >= 70 => 'C',
            $this->oshaAudit->rating >= 60 => 'D',
            $this->oshaAudit->rating >= 50 => 'F',
            default => 'N/A',
        };
    }

    public function download()
    {
        return Storage::disk('do-audits')
            ->download(tenant('id').'/osha/'.$this->oshaAudit->pdf_path);
    }

    public function render()
    {
        return view('livewire.dealer.audit.osha.old-audit-index');
    }
}
