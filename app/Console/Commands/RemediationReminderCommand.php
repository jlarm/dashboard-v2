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
        tenancy()->runForMultiple($this->option('tenants'), function ($tenant) {
            $tenantSlug = tenant('locations') ? true : false;
            $this->processStores(Store::all(), $tenantSlug);
        });
    }

    private function processStores(Collection $stores, bool $tenantSlug): void
    {
        foreach ($stores as $store) {
            if (! $store->remediationSettings || ! $store->remediationSettings->notifications) {
                continue;
            }

            $frequency = $store->remediationSettings->frequency->value();
            $this->processAudits($store, $frequency, $tenantSlug);
        }
    }

    private function processAudits(Store $store, int $frequency, bool $tenantSlug): void
    {
        $oshaAudits = $this->getAuditsDueForReminder($store->oshaViolationAudits(), $frequency);
        $bodyShopAudits = $this->getAuditsDueForReminder($store->bodyShopViolationAudits(), $frequency);
        $glbaAudits = $this->getAuditsDueForReminder($store->glbaViolationAudits(), $frequency);

        $audits = $oshaAudits->merge($bodyShopAudits)->merge($glbaAudits);

        foreach ($audits as $audit) {
            if ($audit->outstanding_remediation_count === 0) {
                continue;
            }
            $this->processAudit($store, $audit, $tenantSlug);
        }
    }

    private function getAuditsDueForReminder($auditQuery, int $frequency)
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

    private function processAudit(Store $store, Model $audit, bool $tenantSlug): void
    {
        $modelBaseName = $this->getModelType($audit);
        $auditType = $this->modelTypeMap[$modelBaseName] ?? null;

        if (! $auditType) {
            $this->warn("Unkown audit type for model: {$modelBaseName}");

            return;
        }

        $this->sendNotifications($store, $auditType, $audit, $tenantSlug);
        $this->updateReminderLogs($audit);
    }

    private function sendNotifications(Store $store, AuditTypes $auditType, Model $audit, bool $tenantSlug): void
    {
        $users = GetRemediationReminderUsers::execute($store, $auditType);

        foreach ($users as $user) {
            $user->notify(new RemediationReminderNotification($tenantSlug, $user, $store, $auditType, $audit));
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
