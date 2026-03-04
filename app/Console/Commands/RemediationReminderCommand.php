<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Enums\AuditTypes;
use App\Models\Dealer\Store;
use App\Notifications\RemediationReminderNotification;
use App\Queries\GetRemediationReminderUsers;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RemediationReminderCommand extends Command
{
    private const MAX_REMINDERS = 3;

    protected $signature = 'remediation:reminder  {--tenants=* : The tenant(s) to run the command for. Default all.}';
    protected $description = 'Command description';
    private array $modelTypeMap = [
        'OshaViolationAudit' => AuditTypes::OSHA,
        'BodyShopViolationAudit' => AuditTypes::BODYSHOP,
        'GlbaViolationAudit' => AuditTypes::GLBA,
    ];

    public function handle(): void
    {
        /** @var \Illuminate\Support\Collection<int, string> $tenants */
        $tenants = collect($this->option('tenants'))
            ->filter(static fn (mixed $tenant): bool => is_string($tenant) && $tenant !== '')
            ->values();

        tenancy()->runForMultiple($tenants->isEmpty() ? null : $tenants, function ($tenant): void {
            $hasMultipleStores = Store::query()->count() > 1;
            $this->processStores(Store::all(), $hasMultipleStores);
        });
    }

    private function processStores(Collection $stores, bool $hasMultipleStores): void
    {
        foreach ($stores as $store) {
            /** @var Store $store */
            if (! $store->remediationSettings) {
                continue;
            }
            if (! $store->remediationSettings->notifications) {
                continue;
            }
            $frequency = $store->remediationSettings->frequency->value();
            $this->processAudits($store, $frequency, $hasMultipleStores);
        }
    }

    private function processAudits(Store $store, int $frequency, bool $hasMultipleStores): void
    {
        $oshaAudits = $this->getAuditsDueForReminder($store->oshaViolationAudits(), $frequency);
        $bodyShopAudits = $this->getAuditsDueForReminder($store->bodyShopViolationAudits(), $frequency);
        $glbaAudits = $this->getAuditsDueForReminder($store->glbaViolationAudits(), $frequency);

        $audits = $oshaAudits->merge($bodyShopAudits)->merge($glbaAudits);

        foreach ($audits as $audit) {
            if ($audit->outstanding_remediation_count === 0) {
                continue;
            }
            $this->processAudit($store, $audit, $hasMultipleStores);
        }
    }

    private function getAuditsDueForReminder(HasMany $auditQuery, int $frequency)
    {
        return $auditQuery
            ->whereNotNull('completed_date')
            ->whereNull('remediation_pdf_path')
            ->whereRaw("
                reminder_logs IS NOT NULL
                AND JSON_LENGTH(reminder_logs) > 0
                AND JSON_LENGTH(reminder_logs) < ?
                AND DATE_ADD(
                    JSON_UNQUOTE(JSON_EXTRACT(reminder_logs, CONCAT('$[', JSON_LENGTH(reminder_logs) - 1, ']'))),
                    INTERVAL ? DAY
                ) = ?
            ", [self::MAX_REMINDERS, $frequency, now()->toDateString()])
            ->get();
    }

    private function processAudit(Store $store, Model $audit, bool $hasMultipleStores): void
    {
        $modelBaseName = $this->getModelType($audit);
        $auditType = $this->modelTypeMap[$modelBaseName] ?? null;

        if (! $auditType) {
            $this->warn("Unkown audit type for model: {$modelBaseName}");

            return;
        }

        $this->sendNotifications($store, $auditType, $audit, $hasMultipleStores);
        $this->updateReminderLogs($audit);
    }

    private function sendNotifications(Store $store, AuditTypes $auditType, Model $audit, bool $hasMultipleStores): void
    {
        $users = GetRemediationReminderUsers::execute($store, $auditType);

        foreach ($users as $user) {
            $user->notify(new RemediationReminderNotification($hasMultipleStores, $user, $store, $auditType, $audit));
        }
    }

    private function updateReminderLogs(Model $audit): void
    {
        $reminderLogs = $audit->reminder_logs ?? [];
        $reminderLogs[] = now()->toDateString();
        $audit->update(['reminder_logs' => $reminderLogs]);
    }

    private function getModelType(Model $model): string
    {
        $modelType = $model->getMorphClass();

        return class_basename($modelType);
    }
}
