<?php

declare(strict_types=1);

use App\Jobs\SendQueueEmailJob;
use App\Models\Dealer\Invite;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Bus;
use Spatie\Permission\PermissionRegistrar;

beforeEach(function (): void {
    $this->consultant->assignRole('super-admin');
    app()->make(PermissionRegistrar::class)->forgetCachedPermissions();
});

describe('employees import endpoint', function (): void {
    it('creates invites and dispatches email jobs for a valid file', function (): void {
        Bus::fake();

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
                [
                    'Name' => 'Bob Example',
                    'Email' => 'bob@example.com',
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

        expect(Invite::query()->pluck('email')->all())
            ->toContain('alice@example.com', 'bob@example.com');

        Bus::assertDispatchedTimes(SendQueueEmailJob::class, 2);
    });

    it('rolls back all invites when any row has validation errors', function (): void {
        Bus::fake();

        $payload = json_encode([
            'employees' => [
                [
                    'Name' => 'Valid Person',
                    'Email' => 'valid@example.com',
                    'Position' => 'Employee',
                ],
                [
                    'Name' => '',
                    'Email' => 'not-an-email',
                    'Position' => 'Employee',
                ],
            ],
        ]);

        $file = UploadedFile::fake()->createWithContent('employees.json', $payload);

        $response = $this
            ->actingAs($this->consultant)
            ->post(route('dealer.employees.import'), ['spreadsheet' => $file]);

        $response->assertRedirect();
        $response->assertSessionHasErrors('spreadsheet');
        $response->assertSessionHas('import_errors');

        expect(Invite::query()->count())->toBe(0);
        Bus::assertNotDispatched(SendQueueEmailJob::class);
    });

    it('forbids users without the create-dealerships permission', function (): void {
        $payload = json_encode(['employees' => []]);
        $file = UploadedFile::fake()->createWithContent('employees.json', $payload);

        $this
            ->actingAs($this->manager)
            ->post(route('dealer.employees.import'), ['spreadsheet' => $file])
            ->assertForbidden();
    });

    it('rejects non-json uploads', function (): void {
        $file = UploadedFile::fake()->create('employees.csv', 10, 'text/csv');

        $this
            ->actingAs($this->consultant)
            ->post(route('dealer.employees.import'), ['spreadsheet' => $file])
            ->assertRedirect()
            ->assertSessionHasErrors('spreadsheet');
    });
});
