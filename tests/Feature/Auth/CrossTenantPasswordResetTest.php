<?php

declare(strict_types=1);

use App\Jobs\CrossTenantPasswordResetJob;
use App\Models\User;
use App\Notifications\ResetPassword;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;

it('always returns success status regardless of whether the email exists', function (): void {
    Queue::fake();

    $response = $this->withoutMiddleware(VerifyCsrfToken::class)
        ->post('/forgot-password', ['email' => 'nobody@example.com']);

    $response->assertSessionHas('status');
    $response->assertSessionDoesntHaveErrors();
});

it('dispatches CrossTenantPasswordResetJob with the submitted email', function (): void {
    Queue::fake();

    $this->withoutMiddleware(VerifyCsrfToken::class)
        ->post('/forgot-password', ['email' => 'user@example.com']);

    Queue::assertPushed(CrossTenantPasswordResetJob::class, fn (CrossTenantPasswordResetJob $job): bool => $job->email === 'user@example.com');
});

it('sends central reset notification for a known central user', function (): void {
    Notification::fake();
    Queue::fake();

    $user = User::factory()->create();

    $this->withoutMiddleware(VerifyCsrfToken::class)
        ->post('/forgot-password', ['email' => $user->email]);

    Notification::assertSentTo($user, ResetPassword::class);
});

it('does not reveal whether an email belongs to a central user', function (): void {
    Queue::fake();

    $knownResponse = $this->withoutMiddleware(VerifyCsrfToken::class)
        ->post('/forgot-password', ['email' => User::factory()->create()->email]);

    $unknownResponse = $this->withoutMiddleware(VerifyCsrfToken::class)
        ->post('/forgot-password', ['email' => 'ghost@example.com']);

    expect($knownResponse->getSession()->get('status'))
        ->toBe($unknownResponse->getSession()->get('status'));
});

it('requires a valid email address', function (): void {
    $response = $this->withoutMiddleware(VerifyCsrfToken::class)
        ->post('/forgot-password', ['email' => 'not-an-email']);

    $response->assertSessionHasErrors('email');
});
