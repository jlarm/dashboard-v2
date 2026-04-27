<?php

declare(strict_types=1);

use App\Domain\Tenant\User\Actions\ImportEmployees;
use App\Domain\Tenant\User\Data\ImportEmployeesResult;
use App\Jobs\ImportEmployeesJob;
use App\Models\Dealer\Invite;
use App\Notifications\EmployeesImportCompleteNotification;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\PermissionRegistrar;

beforeEach(function (): void {
    $this->consultant->assignRole('super-admin');
    app()->make(PermissionRegistrar::class)->forgetCachedPermissions();
});

describe('employees import endpoint', function (): void {
    it('queues an import job for a valid file', function (): void {
        Bus::fake();
        Storage::fake('local');

        $payload = json_encode([
            'employees' => [
                [
                    'Name' => 'Alice Example',
                    'Email' => 'alice@example.com',
                    'Stores' => null,
                    'Department' => null,
                    'Position' => 'Employee',
                    'Training' => [],
                ],
            ],
        ]);

        $file = UploadedFile::fake()->createWithContent('employees.json', $payload);

        $response = $this
            ->actingAs($this->consultant)
            ->post(route('dealer.employees.import'), ['spreadsheet' => $file]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        Bus::assertDispatched(ImportEmployeesJob::class, fn (ImportEmployeesJob $job): bool => Storage::disk('local')->exists($job->payloadPath)
                && $job->importer->is($this->consultant));
    });

    it('rejects malformed json synchronously', function (): void {
        Bus::fake();

        $file = UploadedFile::fake()->createWithContent('employees.json', '{"not_employees": []}');

        $this
            ->actingAs($this->consultant)
            ->post(route('dealer.employees.import'), ['spreadsheet' => $file])
            ->assertRedirect()
            ->assertSessionHasErrors('spreadsheet');

        Bus::assertNothingDispatched();
    });

    it('forbids non-super-admin users', function (): void {
        Bus::fake();

        $payload = json_encode(['employees' => []]);
        $file = UploadedFile::fake()->createWithContent('employees.json', $payload);

        $this
            ->actingAs($this->manager)
            ->post(route('dealer.employees.import'), ['spreadsheet' => $file])
            ->assertForbidden();

        Bus::assertNothingDispatched();
    });

    it('rejects non-json uploads', function (): void {
        Bus::fake();

        $file = UploadedFile::fake()->create('employees.csv', 10, 'text/csv');

        $this
            ->actingAs($this->consultant)
            ->post(route('dealer.employees.import'), ['spreadsheet' => $file])
            ->assertRedirect()
            ->assertSessionHasErrors('spreadsheet');

        Bus::assertNothingDispatched();
    });
});

describe('ImportEmployeesJob', function (): void {
    it('runs the import action and notifies the importer on success', function (): void {
        Notification::fake();
        Storage::fake('local');

        $payload = json_encode([
            'employees' => [
                [
                    'Name' => 'Imported Person',
                    'Email' => 'imported@example.com',
                    'Stores' => null,
                    'Department' => null,
                    'Position' => 'Employee',
                    'Training' => [],
                ],
            ],
        ]);

        $payloadPath = 'imports/test/'.uniqid().'.json';
        Storage::disk('local')->put($payloadPath, (string) $payload);

        (new ImportEmployeesJob($this->consultant, $payloadPath))
            ->handle(app(ImportEmployees::class));

        expect(Storage::disk('local')->exists($payloadPath))->toBeFalse();
        expect(Invite::query()->where('email', 'imported@example.com')->exists())->toBeTrue();

        Notification::assertSentTo(
            $this->consultant,
            EmployeesImportCompleteNotification::class,
            fn (EmployeesImportCompleteNotification $notification): bool => $notification->result instanceof ImportEmployeesResult,
        );
    });

    it('cleans up the payload file when the job fails', function (): void {
        Storage::fake('local');

        $payloadPath = 'imports/test/'.uniqid().'.json';
        Storage::disk('local')->put($payloadPath, 'irrelevant');

        $job = new ImportEmployeesJob($this->consultant, $payloadPath);
        $job->failed(new RuntimeException('boom'));

        expect(Storage::disk('local')->exists($payloadPath))->toBeFalse();
    });
});
