<?php

declare(strict_types=1);

namespace App\Domain\Tenant\User\Actions;

use App\Domain\Tenant\User\Data\ImportEmployeesResult;
use App\Jobs\SendQueueEmailJob;
use App\Models\Dealer\Invite;
use App\Models\User;
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
        /** @var array{employees?: array<int, array<string, mixed>>}|null $payload */
        $payload = json_decode($jsonContent, true);

        if (! is_array($payload) || ! isset($payload['employees']) || ! is_array($payload['employees'])) {
            throw new RuntimeException('The file must be a JSON object containing an "employees" array.');
        }

        /** @var list<array{row: int, errors: list<string>, values: array<string, mixed>}> $errors */
        $errors = [];
        /** @var list<Invite> $created */
        $created = [];
        $skipped = 0;

        DB::beginTransaction();

        try {
            foreach ($payload['employees'] as $index => $item) {
                if (! is_array($item)) {
                    $errors[] = [
                        'row' => $index + 1,
                        'errors' => ['Row must be an object.'],
                        'values' => [],
                    ];

                    continue;
                }

                $validator = Validator::make($item, [
                    'Name' => ['required', 'string'],
                    'Email' => ['required', 'email', 'unique:users,email', 'unique:invites,email'],
                    'Stores' => ['nullable'],
                    'Department' => ['nullable'],
                    'Position' => ['nullable'],
                    'Training' => ['nullable', 'array'],
                ]);

                if ($validator->fails()) {
                    $messages = $validator->errors()->all();

                    if (count($messages) === 1 && str_contains($messages[0], 'email has already been taken')) {
                        $skipped++;

                        continue;
                    }

                    $errors[] = [
                        'row' => $index + 1,
                        'errors' => array_values(array_map(strval(...), $messages)),
                        'values' => $item,
                    ];

                    continue;
                }

                $stores = $item['Stores'] ?? null;

                $created[] = Invite::query()->create([
                    'name' => $item['Name'],
                    'email' => $item['Email'],
                    'stores' => $stores === null ? null : array_map(strval(...), (array) $stores),
                    'department_id' => $item['Department'] ?? null,
                    'user_id' => $importer->id,
                    'roles' => [$item['Position'] ?? null],
                    'courses' => $this->transformTraining($item['Training'] ?? []),
                    'invitation_token' => Str::random(32),
                ]);
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
            if (! is_array($entry) || ! isset($entry['Course'], $entry['Training Date'])) {
                continue;
            }

            $courses[(string) $entry['Course']] = (string) $entry['Training Date'];
        }

        return $courses;
    }
}
