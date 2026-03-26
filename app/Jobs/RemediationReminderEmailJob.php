<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Enums\AuditTypes;
use App\Models\Dealer\Audit\BodyShopViolationAudit;
use App\Models\Dealer\Audit\GlbaViolationAudit;
use App\Models\Dealer\Audit\OshaViolationAudit;
use App\Models\Dealer\Store;
use App\Notifications\InitialRemediationReminderNotification;
use App\Queries\GetRemediationReminderUsers;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class RemediationReminderEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected bool $tenants,
        protected Store $store,
        protected ?Model $audit,
        protected AuditTypes $auditType
    ) {}

    public function handle(): void
    {
        /** @var OshaViolationAudit|BodyShopViolationAudit|GlbaViolationAudit|null $audit */
        $audit = $this->audit;

        if ($audit === null) {
            return;
        }

        if ($audit->completed_date) {
            return;
        }

        $audit->update(['completed_date' => now()]);

        $users = GetRemediationReminderUsers::execute($this->store, $this->auditType);

        foreach ($users as $user) {
            $user->notify(new InitialRemediationReminderNotification($this->tenants, $user, $this->store, $this->auditType, $audit));
        }

        if ($audit->reminder_logs === null) {
            $audit->update([
                'reminder_logs' => [now()->toDateString()],
            ]);
        }
    }

    public function failed(?Throwable $exception): void
    {
        if ($exception !== null) {
            report($exception);
        }
    }
}
