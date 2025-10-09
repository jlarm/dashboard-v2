<?php

namespace App\Jobs;

use App\Models\Dealer\Invite;
use DB;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Validator;

class ImportEmployeesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    protected $userId;

    public function __construct(array $data, int $userId)
    {
        $this->data = $data;
        $this->userId = $userId;
    }

    public function handle(): void
    {
        $importErrors = [];

        DB::transaction(function () use (&$importErrors) {
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

                    $invite = Invite::create([
                        'name' => $item['Name'],
                        'email' => $item['Email'],
                        'stores' => $item['Stores'] === null ? null : [$item['Stores']],
                        'department_id' => $item['Department'],
                        'user_id' => $this->userId,
                        'roles' => [$item['Role']],
                        'courses' => $item['Courses'],
                        'invitation_token' => mb_substr(md5(rand(0, 9).$item['Email'].time()), 0, 32),
                    ]);

                    SendQueueEmailJob::dispatch($invite, 'invite');
                } catch (Exception $e) {
                    $importErrors[] = [
                        'row' => $index + 1,
                        'errors' => [$e->getMessage()],
                        'values' => $item,
                    ];
                }
            }

            if (! empty($importErrors)) {
                throw new Exception('Import failed due to errors');
            }
        });
    }
}
