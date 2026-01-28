<?php

declare(strict_types=1);

namespace App\Jobs;

use Exception;
use Http;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RedSentryReportGenerationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(

    ) {}

    public function handle()
    {
        try {

            $user = Http::post('https://blue-api.redsentry.com/login', [
                'username' => env('RED_SENTRY_USER'),
                'password' => env('RED_SENTRY_PASS'),
            ]);

            $token = $user['token'];

            $token = null;

        } catch (Exception $e) {

        }
    }
}
