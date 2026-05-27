<?php

declare(strict_types=1);

use App\Jobs\SendCustomEmployeeMessageJob;
use App\Mail\CustomEmployeeMessageMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

it('mails a CustomEmployeeMessageMail to the targeted user with the provided subject and body', function (): void {
    Mail::fake();

    $user = User::query()->create([
        'name' => 'Pat Employee',
        'email' => 'pat-custom-'.uniqid().'@test-tenant.localhost',
        'password' => bcrypt('x'),
    ]);

    new SendCustomEmployeeMessageJob(
        user: $user,
        subject: 'Compliance reminder',
        messageBody: 'Please complete your training by Friday.',
    )->handle();

    Mail::assertSent(CustomEmployeeMessageMail::class, fn (CustomEmployeeMessageMail $mail): bool => $mail->hasTo($user->email)
            && $mail->emailSubject === 'Compliance reminder'
            && $mail->messageBody === 'Please complete your training by Friday.');
});

it('does not throw when failed() is invoked with or without an exception', function (): void {
    $user = User::query()->create([
        'name' => 'Pat Employee',
        'email' => 'pat-failed-'.uniqid().'@test-tenant.localhost',
        'password' => bcrypt('x'),
    ]);

    $job = new SendCustomEmployeeMessageJob($user, 'subj', 'body');

    expect(fn () => $job->failed(null))->not->toThrow(Throwable::class);
    expect(fn () => $job->failed(new RuntimeException('smtp down')))->not->toThrow(Throwable::class);
});
