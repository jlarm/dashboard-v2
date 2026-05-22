<?php

declare(strict_types=1);

namespace App\Domain\Tenant\User\Actions;

use App\Domain\Tenant\User\Data\ImportEmployeesResult;
use App\Enums\Role;
use App\Jobs\SendQueueEmailJob;
use App\Models\Dealer\Invite;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use RuntimeException;
use Throwable;

class ImportEmployees
{
    /**
     * @throws RuntimeException When the payload is not valid JSON or missing the employees key.
     */
    public function handle(User $importer, string $jsonContent): ImportEmployeesResult
    {
        $payload = json_decode($jsonContent, true);

        throw_if(! is_array($payload) || ! isset($payload['employees']) || ! is_array($payload['employees']), RuntimeException::class, 'The file must be a JSON object containing an "employees" array.');

        /** @var array<int, array<string, mixed>> $employees */
        $employees = $payload['employees'];
        $existingEmails = $this->existingEmails($employees);

        /** @var list<array{row: int, errors: list<string>, values: array<string, mixed>}> $errors */
        $errors = [];
        /** @var list<Invite> $created */
        $created = [];
        $skipped = 0;

        DB::beginTransaction();

        try {
            foreach ($employees as $index => $item) {

                $email = is_string($item['Email'] ?? null) ? mb_strtolower($item['Email']) : null;

                if ($email !== null && $existingEmails->contains($email)) {
                    $skipped++;

                    continue;
                }

                $validator = Validator::make($item, [
                    'Name' => ['required', 'string'],
                    'Email' => ['required', 'email'],
                    'Stores' => ['nullable'],
                    'Department' => ['nullable'],
                    'Position' => ['nullable'],
                    'Training' => ['nullable', 'array'],
                ]);

                if ($validator->fails()) {
                    $errors[] = [
                        'row' => $index + 1,
                        'errors' => array_values(array_map(strval(...), $validator->errors()->all())),
                        'values' => $item,
                    ];

                    continue;
                }

                if ($email === null) {
                    continue;
                }

                $stores = $item['Stores'] ?? null;
                $position = is_string($item['Position'] ?? null) && $item['Position'] !== ''
                    ? $item['Position']
                    : Role::Employee->value;

                $created[] = Invite::query()->create([
                    'name' => $item['Name'],
                    'email' => $email,
                    'stores' => $stores === null ? null : array_map(strval(...), (array) $stores),
                    'department_id' => $item['Department'] ?? null,
                    'user_id' => $importer->id,
                    'roles' => [$position],
                    'courses' => $this->transformTraining($item['Training'] ?? []),
                    'invitation_token' => Str::random(32),
                ]);

                $existingEmails->push($email);
            }

            if ($errors !== []) {
                DB::rollBack();

                return new ImportEmployeesResult(
                    successCount: 0,
                    skippedCount: 0,
                    errors: $errors,
                );
            }

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();

            throw $e;
        }

        foreach ($created as $invite) {
            dispatch(new SendQueueEmailJob($invite));
        }

        return new ImportEmployeesResult(
            successCount: count($created),
            skippedCount: $skipped,
            errors: $errors,
        );
    }

    /**
     * @param  array<int, array<string, mixed>>  $rows
     * @return Collection<int, string>
     */
    private function existingEmails(array $rows): Collection
    {
        $emails = collect($rows)
            ->map(static fn (array $row): ?string => is_string($row['Email'] ?? null)
                ? mb_strtolower($row['Email'])
                : null)
            ->filter()
            ->unique()
            ->values();

        if ($emails->isEmpty()) {
            return collect();
        }

        /** @phpstan-ignore return.type */
        return User::query()
            ->whereIn('email', $emails)
            ->pluck('email')
            ->merge(Invite::query()->whereIn('email', $emails)->pluck('email'))
            ->map(static fn (mixed $email): string => mb_strtolower((string) $email))
            ->unique()
            ->values();
    }

    /**
     * @param  array<int, array{Course?: string, 'Training Date'?: string}>|mixed  $training
     * @return array<string, string>
     */
    private function transformTraining(mixed $training): array
    {
        if (! is_array($training)) {
            return [];
        }

        $courses = [];
        foreach ($training as $entry) {
            if (! is_array($entry)) {
                continue;
            }
            if (! isset($entry['Course'], $entry['Training Date'])) {
                continue;
            }
            $courses[(string) $entry['Course']] = (string) $entry['Training Date'];
        }

        return $courses;
    }
}
