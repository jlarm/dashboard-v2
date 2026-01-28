<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Audit\Osha;

use App\Models\Dealer\Audit\OshaAudit;
use Livewire\Component;
use Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Download extends Component
{
    public OshaAudit $oshaAudit;
    public $content;

    public function mount()
    {

        $this->content = Storage::disk('do-audits')->url(tenant('id').'/osha/'.$this->oshaAudit->pdf_path);
    }

    public function download(): StreamedResponse
    {
        return Storage::disk('do-audits')->download(tenant('id').'/osha/'.$this->oshaAudit->pdf_path);
    }

    public function render()
    {
        return view('livewire.dealer.audit.osha.download');
    }
}
