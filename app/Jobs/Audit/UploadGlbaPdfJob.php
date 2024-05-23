<?php

namespace App\Jobs\Audit;

use App\Models\Dealer\Audit\GlbaViolationAudit;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;
use Storage;

class UploadGlbaPdfJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected GlbaViolationAudit $glbaViolationAudit)
    {
    }

    public function middleware(): array
    {
        return [new WithoutOverlapping($this->glbaViolationAudit)];
    }

    public function handle(): void
    {
        $pdf = Storage::get('/'.$this->glbaViolationAudit->pdf_path);
        $path = tenant('id').'/glba/'.$this->glbaViolationAudit->pdf_path;
        $move = Storage::disk('armpaudits')->put(tenant('id').'/glba/'.$this->glbaViolationAudit->pdf_path, $pdf);
        if ($move) {
            Storage::delete('/', $this->glbaViolationAudit->pdf_path);
            $this->glbaViolationAudit->update(['pdf_path' => $path]);
        }
    }
}
