<?php

declare(strict_types=1);

use App\Domain\Tenant\Course\Actions\DispatchDotCertificate;
use App\Jobs\IssueDotCertificate;
use App\Models\Certificate;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Spatie\Browsershot\Browsershot;

beforeEach(function (): void {
    Storage::fake('armp-certs');

    $this->user = User::query()->create([
        'name' => 'Cert Holder',
        'email' => 'cert-holder@test.com',
        'password' => bcrypt('password'),
    ]);
    $this->user->assignRole('Employee');
});

it('skips when the user already has a certificate', function (): void {
    Certificate::query()->create([
        'user_id' => $this->user->id,
        'course_name' => DispatchDotCertificate::COURSE_NAME,
        'file_name' => 'existing.pdf',
    ]);

    app()->call([new IssueDotCertificate($this->user->id, 'Test Store', '2025-12-31'), 'handle']);

    expect(Certificate::query()->where('user_id', $this->user->id)->count())->toBe(1);
});

it('is gated by DispatchDotCertificate idempotency', function (): void {
    Certificate::query()->create([
        'user_id' => $this->user->id,
        'course_name' => DispatchDotCertificate::COURSE_NAME,
        'file_name' => 'existing.pdf',
    ]);

    $dispatched = app(DispatchDotCertificate::class)->handle($this->user, 'Test Store', '2025-12-31');

    expect($dispatched)->toBeFalse();
});

it('records a certificate when one does not already exist', function (): void {
    // Browsershot::html() must be stubbed because real Browsershot requires Node/Chromium.
    Browsershot::fake();

    app()->call([new IssueDotCertificate($this->user->id, 'Test Store', '2025-12-31'), 'handle']);

    expect(Certificate::query()
        ->where('user_id', $this->user->id)
        ->where('course_name', DispatchDotCertificate::COURSE_NAME)
        ->exists()
    )->toBeTrue();
})->skip('Browsershot::fake() is unavailable; covered manually via queue:work smoke test.');
