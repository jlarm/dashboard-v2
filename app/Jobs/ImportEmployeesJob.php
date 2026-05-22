<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Domain\Tenant\User\Actions\ImportEmployees;
use App\Models\User;
use App\Notifications\EmployeesImportCompleteNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ImportEmployeesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 1;

    public function __construct(
        public User $importer,
        public string $payloadPath,
    ) {}

    public function handle(ImportEmployees $action): void
    {
        $disk = Storage::disk('local');

        try {
            $jsonContent = (string) $disk->get($this->payloadPath);
            $result = $action->handle($this->importer, $jsonContent);
        } finally {
            $disk->delete($this->payloadPath);
        }

        $this->importer->notify(new EmployeesImportCompleteNotification($result));
    }

    public function failed(?Throwable $exception): void
    {
        Storage::disk('local')->delete($this->payloadPath);

        if (! $exception instanceof Throwable) {
            return;
        }

        report($exception);
    }
}
