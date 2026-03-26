<?php

declare(strict_types=1);

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\MailgunWebhookController;
use Illuminate\Support\Facades\Route;

Route::post('/auth', AuthController::class)
    ->middleware('throttle:5,1')
    ->name('api.auth');

// Mailgun webhook endpoint (no authentication required - verified via signature)
Route::post('/webhooks/mailgun', [MailgunWebhookController::class, 'handle'])
    ->name('webhooks.mailgun');
