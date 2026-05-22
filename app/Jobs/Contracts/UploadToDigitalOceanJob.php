<?php

declare(strict_types=1);

namespace App\Jobs\Contracts;

use App\Models\Contract;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Throwable;

class UploadToDigitalOceanJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected Contract $contract) {}

    /**
     * @return array<int, object>
     */
    public function middleware(): array
    {
        return [new WithoutOverlapping(static::class.'-'.$this->contract->getKey())];
    }

    public function handle(): void
    {
        $pdf = Storage::get('contracts/'.$this->contract->pdf_path);
        if ($pdf === null) {
            return;
        }
        $move = Storage::disk('armpcon')->put($this->contract->uuid.'/'.$this->contract->pdf_path, $pdf);
        if ($move) {
            Storage::delete('contracts/'.$this->contract->pdf_path);

            $this->contract->update([
                'pdf_path' => $this->contract->uuid.'/'.$this->contract->pdf_path,
            ]);
        }

    }

    public function failed(?Throwable $exception): void
    {
        if (! $exception instanceof Throwable) {
            return;
        }

        report($exception);
    }
}
