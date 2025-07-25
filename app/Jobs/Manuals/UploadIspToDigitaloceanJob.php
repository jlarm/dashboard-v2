<?php

namespace App\Jobs\Manuals;

use App\Models\Dealer\Manual\Isp;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class UploadIspToDigitaloceanJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected Isp $manual) {}

    public function middleware(): array
    {
        return [new WithoutOverlapping($this->manual)];
    }

    public function handle(): void
    {
        $pdf = Storage::get('/'.$this->manual->pdf_path);
        $moved = Storage::disk('do-manuals')->put(tenant('id').'/isp/'.$this->manual->pdf_path, $pdf);
        if ($moved) {
            Storage::delete('/'.$this->manual->pdf_path);
        }
    }
}
