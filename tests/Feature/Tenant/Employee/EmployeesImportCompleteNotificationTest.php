<?php

declare(strict_types=1);

use App\Domain\Tenant\User\Data\ImportEmployeesResult;
use App\Notifications\EmployeesImportCompleteNotification;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Messages\MailMessage;

it('routes through both mail and database channels', function (): void {
    $result = new ImportEmployeesResult(successCount: 1, skippedCount: 0, errors: []);

    expect((new EmployeesImportCompleteNotification($result))->via(new AnonymousNotifiable))
        ->toBe(['mail', 'database']);
});

describe('success payload', function (): void {
    it('builds a database payload with success copy and two action links', function (): void {
        $result = new ImportEmployeesResult(successCount: 4, skippedCount: 2, errors: []);

        $payload = (new EmployeesImportCompleteNotification($result))->toArray(new AnonymousNotifiable);

        expect($payload['title'])->toBe('Employee import complete')
            ->and($payload['message'])->toBe('4 invite(s) imported, 2 skipped.')
            ->and($payload['level'])->toBe('success')
            ->and($payload['icon'])->toBe('UserPlus');

        expect($payload['actions'])->toHaveCount(2);
        expect($payload['actions'][0]['url'])->toBe(route('dealer.employees.index'));
        expect($payload['actions'][1]['url'])->toBe(route('dealer.employees.open-invites'));
    });

    it('builds a success email that mentions both the import and skip counts', function (): void {
        $result = new ImportEmployeesResult(successCount: 7, skippedCount: 3, errors: []);

        $message = (new EmployeesImportCompleteNotification($result))->toMail(new AnonymousNotifiable);

        expect($message)->toBeInstanceOf(MailMessage::class)
            ->and($message->subject)->toBe('Employee import results');

        $body = implode("\n", [...$message->introLines, ...$message->outroLines]);
        expect($body)
            ->toContain('7 invite(s) were imported successfully.')
            ->toContain('3 row(s) were skipped');
    });

    it('omits the skipped sentence when none were skipped', function (): void {
        $result = new ImportEmployeesResult(successCount: 5, skippedCount: 0, errors: []);

        $message = (new EmployeesImportCompleteNotification($result))->toMail(new AnonymousNotifiable);

        $body = implode("\n", [...$message->introLines, ...$message->outroLines]);
        expect($body)
            ->toContain('5 invite(s) were imported successfully.')
            ->not->toContain('skipped');
    });
});

describe('error payload', function (): void {
    it('builds an error database payload when any row failed', function (): void {
        $result = new ImportEmployeesResult(
            successCount: 0,
            skippedCount: 0,
            errors: [
                ['row' => 2, 'errors' => ['Invalid email'], 'values' => []],
                ['row' => 4, 'errors' => ['Missing name'], 'values' => []],
            ],
        );

        $payload = (new EmployeesImportCompleteNotification($result))->toArray(new AnonymousNotifiable);

        expect($payload['title'])->toBe('Employee import failed')
            ->and($payload['message'])->toBe('2 row(s) had errors. The import was rolled back.')
            ->and($payload['level'])->toBe('error')
            ->and($payload['icon'])->toBe('AlertTriangle');

        expect($payload['actions'])->toHaveCount(1);
        expect($payload['actions'][0]['url'])->toBe(route('dealer.employees.index'));
    });

    it('lists up to ten error rows in the failure email and notes the overflow', function (): void {
        $errors = [];
        for ($i = 1; $i <= 12; $i++) {
            $errors[] = ['row' => $i, 'errors' => ["Problem on row {$i}"], 'values' => []];
        }
        $result = new ImportEmployeesResult(successCount: 0, skippedCount: 0, errors: $errors);

        $message = (new EmployeesImportCompleteNotification($result))->toMail(new AnonymousNotifiable);

        $body = implode("\n", [...$message->introLines, ...$message->outroLines]);
        expect($body)
            ->toContain('12 row(s) had errors')
            ->toContain('Row 1: Problem on row 1')
            ->toContain('Row 10: Problem on row 10')
            ->toContain('...and 2 more.')
            ->not->toContain('Row 11:')
            ->not->toContain('Row 12:');
    });
});
