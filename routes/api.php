<?php

declare(strict_types=1);

use App\Http\Controllers\Api\MailgunWebhookController;
use Illuminate\Support\Facades\Route;

// Mailgun webhook endpoint (no authentication required - verified via signature)
Route::post('/webhooks/mailgun', [MailgunWebhookController::class, 'handle'])
    ->name('webhooks.mailgun');
