<?php

namespace App\Jobs;

use App\Models\Dealer\Audit\IndividualAudit;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;

class UploadIndividualAuditToDigitalOceanJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 240;
    public $audits;

    public function __construct(protected IndividualAudit $individualAudit)
    {
        $this->audits = $this->individualAudit
            ->where('id', $this->individualAudit->id)
            ->orWhere('parent_id', $this->individualAudit->id)
            ->get();
    }

    public function middleware(): array
    {
        return [new WithoutOverlapping($this->individualAudit)];
    }

    public function handle(): void
    {
        $mergePdf = PDFMerger::init();

        foreach($this->audits as $audit) {
            $mergePdf->addPDF(storage_path('app/individual-audits/' . $audit->pdf_path), 'all');
        }

        $mergePdf->merge();

        $name = 'individual-audit-' . now()->format('Ymdhis') . '.pdf';

        $mergePdf->save(storage_path('app/individual-audits/' . $name));

        foreach($this->audits as $audit) {
            Storage::delete('/individual-audits/' . $audit->pdf_path);
        }

        $pdf = Storage::get('/individual-audits/' . $name);

        Storage::disk('do-audits')->put(tenant('id') . '/individual-audits/' . $name, $pdf);

        Storage::delete('/individual-audits/' . $name);

        $updatePath = $this->individualAudit->update([
            'pdf_path' => $name,
        ]);
        $updateChildPath = $this->individualAudit->where('parent_id', $this->individualAudit->id)->update([
            'pdf_path' => null,
        ]);
    }
}
