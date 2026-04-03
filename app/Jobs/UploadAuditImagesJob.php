<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Dealer\Violation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Throwable;

class UploadAuditImagesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected Violation $violation, protected array $files) {}

    public function handle(): void
    {
        foreach ($this->files as $path) {
            // Check if a file exists at the path
            if (Storage::disk('public')->exists($path)) {
                // Retrieve the file using the path
                $file = Storage::disk('public')->get($path);
                $this->violation->addMediaFromDisk($file, 'public')
                    ->toMediaCollection('violation_files');
                // Delete the temporary file
                Storage::disk('public')->delete($path);
            }
        }
    }

    public function failed(?Throwable $exception): void
    {
        report_if($exception instanceof Throwable, $exception);
    }
}
