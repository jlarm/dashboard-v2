<?php

declare(strict_types=1);

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class TestRedisJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // This is the core action: writing a distinct message to the log.
        Log::info('*** REDIS QUEUE TEST SUCCESSFUL: TestRedisJob was processed! ***');
    }

    public function failed(?Throwable $exception): void
    {
        if (! $exception instanceof Throwable) {
            return;
        }

        report($exception);
    }
}
