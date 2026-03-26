<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Dealer\Invite;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Throwable;

class ImportEmployeesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected array $data, protected int $userId) {}

    public function handle(): void
    {
        $importErrors = [];

        DB::transaction(function () use (&$importErrors): void {
            foreach ($this->data as $index => $item) {
                try {
                    $validator = Validator::make($item, [
                        'Name' => 'required|string',
                        'Email' => 'required|email|unique:users,email|unique:invites,email',
                        'Stores' => 'nullable',
                        'Department' => 'nullable',
                        'Role' => 'nullable',
                    ]);

                    if ($validator->fails()) {
                        $importErrors[] = [
                            'row' => $index + 1,
                            'errors' => $validator->errors()->all(),
                            'values' => $item,
                        ];

                        continue;
                    }

                    $invite = Invite::query()->create([
                        'name' => $item['Name'],
                        'email' => $item['Email'],
                        'stores' => $item['Stores'] === null ? null : [$item['Stores']],
                        'department_id' => $item['Department'],
                        'user_id' => $this->userId,
                        'roles' => [$item['Role']],
                        'courses' => $item['Courses'],
                        'invitation_token' => mb_substr(md5(random_int(0, 9).$item['Email'].time()), 0, 32),
                    ]);

                    SendQueueEmailJob::dispatch($invite);
                } catch (Exception $e) {
                    $importErrors[] = [
                        'row' => $index + 1,
                        'errors' => [$e->getMessage()],
                        'values' => $item,
                    ];
                }
            }

            throw_unless($importErrors === [], new Exception('Import failed due to errors'));
        });
    }

    public function failed(?Throwable $exception): void
    {
        if ($exception !== null) {
            report($exception);
        }
    }
}
