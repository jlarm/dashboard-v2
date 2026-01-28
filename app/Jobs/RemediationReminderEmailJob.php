<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Enums\AuditTypes;
use App\Models\Dealer\Store;
use App\Notifications\InitialRemediationReminderNotification;
use App\Queries\GetRemediationReminderUsers;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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
        if ($this->audit->completed_date) {
            return;
        }

        $this->audit->update(['completed_date' => now()]);

        $users = GetRemediationReminderUsers::execute($this->store, $this->auditType);

        foreach ($users as $user) {
            $user->notify(new InitialRemediationReminderNotification($this->tenants, $user, $this->store, $this->auditType, $this->audit));
        }

        if ($this->audit->reminder_logs === null) {
            $this->audit->update([
                'reminder_logs' => [now()->toDateString()],
            ]);
        }
    }
}
