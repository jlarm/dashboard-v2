<?php

namespace App\Http\Livewire\Dealer\Employee;

use App\Jobs\SendQueueEmailJob;
use App\Models\Dealer\Invite;
use Exception;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Livewire\WithFileUploads;
use WireElements\Pro\Components\Modal\Modal;

class Import extends Modal
{
    use WithFileUploads;

    public $spreadsheet;
    public $importErrors = [];
    public $successCount = 0;

    public function import(): void
    {
        $this->validate();
        $this->importErrors = [];

        try {
            $jsonContent = file_get_contents($this->spreadsheet->getRealPath());
            $data = json_decode($jsonContent, true);

            DB::transaction(function () use ($data) {
                foreach ($data['employees'] as $index => $item) {
                    try {
                        $validator = Validator::make($item, [
                            'Name' => 'required|string',
                            'Email' => 'required|email|unique:users,email|unique:invites,email',
                            'Stores' => 'nullable',
                            'Department' => 'nullable',
                            'Position' => 'nullable',
                            'Training' => 'nullable|array',
                        ]);

                        if ($validator->fails()) {
                            $errors = $validator->errors()->all();

                            // Skip only if the only error is email already taken
                            if (count($errors) === 1 && str_contains($errors[0], 'email has already been taken')) {
                                continue;
                            }

                            $this->importErrors[] = [
                                'errors' => $errors,
                                'values' => $item,
                            ];

                            continue;
                        }

                        // Transform Training array to the required format
                        $courses = [];
                        if (! empty($item['Training'])) {
                            foreach ($item['Training'] as $training) {
                                $courses[$training['Course']] = $training['Training Date'];
                            }
                        }

                        Invite::create([
                            'name' => $item['Name'],
                            'email' => $item['Email'],
                            'stores' => $item['Stores'] === null ? null : array_map('strval', (array) $item['Stores']),
                            'department_id' => $item['Department'],
                            'user_id' => auth()->id(),
                            'roles' => [$item['Position']],
                            'courses' => $courses, // Updated to use the transformed courses
                            'invitation_token' => mb_substr(md5(rand(0, 9).$item['Email'].time()), 0, 32),
                        ]);
                    } catch (Exception $e) {
                        $this->importErrors[] = [
                            'row' => $index + 1,
                            'errors' => [$e->getMessage()],
                            'values' => $item,
                        ];
                    }
                }

                if (! empty($this->importErrors)) {
                    throw new Exception('Import failed due to errors');
                }
            });

            // If we reach here, it means the transaction was successful
            $invites = Invite::where('user_id', auth()->id())->latest()->take(count($data['employees']))->get();
            foreach ($invites as $invite) {
                SendQueueEmailJob::dispatch($invite, 'invite');
                $this->successCount++;
            }

            Notification::make()
                ->title("{$this->successCount} Invites Imported Successfully")
                ->success()
                ->send();

            $this->close();
        } catch (Exception $exception) {
            $this->emit('importFailed');
        }
    }

    public function render()
    {
        return view('livewire.dealer.employee.import');
    }

    protected function rules(): array
    {
        return [
            'spreadsheet' => 'required|file|mimes:json',
        ];
    }
}
