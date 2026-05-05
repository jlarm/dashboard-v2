<?php

declare(strict_types=1);

use App\Domain\Tenant\Compliance\Queries\CalculateOverdueRemediations;
use App\Enums\Frequency;
use App\Models\Dealer\Audit\OshaViolationAudit;
use App\Models\Dealer\Store;
use App\Models\Remediation;
use App\Models\RemediationSetting;
use Carbon\CarbonImmutable;
use Illuminate\Support\Str;

beforeEach(function (): void {
    $this->store = Store::query()->firstOrFail();

    RemediationSetting::query()->create([
        'store_id' => $this->store->id,
        'active' => true,
        'notifications' => true,
        'frequency' => Frequency::WEEKLY->value,
        'managers' => [],
    ]);
});

it('returns zero counts when the store has no remediation setting', function (): void {
    RemediationSetting::query()->where('store_id', $this->store->id)->delete();
    $this->store->unsetRelation('remediationSettings');

    createAudit($this->store, $this->consultant, completedDaysAgo: 30, severities: [9, 5]);

    $result = (new CalculateOverdueRemediations())->handle($this->store, CarbonImmutable::now());

    expect($result)->toBe(['count' => 0, 'high_severity_count' => 0]);
});

it('returns zero counts when the remediation setting exists but is inactive', function (): void {
    RemediationSetting::query()->where('store_id', $this->store->id)->update(['active' => false]);
    $this->store->unsetRelation('remediationSettings');

    createAudit($this->store, $this->consultant, completedDaysAgo: 30, severities: [9, 5]);

    $result = (new CalculateOverdueRemediations())->handle($this->store, CarbonImmutable::now());

    expect($result)->toBe(['count' => 0, 'high_severity_count' => 0]);
});

it('does not count audits whose grace window has not yet passed', function (): void {
    // Frequency is WEEKLY (7 days). Audit completed 5 days ago is still inside the window.
    createAudit($this->store, $this->consultant, completedDaysAgo: 5, severities: [9, 9]);

    $result = (new CalculateOverdueRemediations())->handle($this->store, CarbonImmutable::now());

    expect($result)->toBe(['count' => 0, 'high_severity_count' => 0]);
});

it('counts violations on audits past the grace window', function (): void {
    createAudit($this->store, $this->consultant, completedDaysAgo: 30, severities: [9, 5, 8]);

    $result = (new CalculateOverdueRemediations())->handle($this->store, CarbonImmutable::now());

    expect($result)->toBe(['count' => 3, 'high_severity_count' => 2]);
});

it('treats severity 8 as high but severity 7 as not high', function (): void {
    createAudit($this->store, $this->consultant, completedDaysAgo: 30, severities: [7, 8]);

    $result = (new CalculateOverdueRemediations())->handle($this->store, CarbonImmutable::now());

    expect($result)->toBe(['count' => 2, 'high_severity_count' => 1]);
});

it('skips violations whose remediation is already completed', function (): void {
    $audit = createAudit($this->store, $this->consultant, completedDaysAgo: 30, severities: [9, 9]);

    $userId = $this->consultant->id;

    $audit->violations->take(1)->each(static function ($violation) use ($userId): void {
        Remediation::query()->create([
            'violation_id' => $violation->id,
            'user_id' => $userId,
            'comment' => 'Resolved',
            'completed' => true,
            'completed_date' => CarbonImmutable::now(),
        ]);
    });

    $result = (new CalculateOverdueRemediations())->handle($this->store, CarbonImmutable::now());

    expect($result)->toBe(['count' => 1, 'high_severity_count' => 1]);
});

it('skips audits whose remediation pdf has been generated', function (): void {
    $audit = createAudit($this->store, $this->consultant, completedDaysAgo: 30, severities: [9, 9]);
    $audit->update(['remediation_pdf_path' => 'remediations/done.pdf']);

    $result = (new CalculateOverdueRemediations())->handle($this->store, CarbonImmutable::now());

    expect($result)->toBe(['count' => 0, 'high_severity_count' => 0]);
});

/**
 * @param  list<int>  $severities
 */
function createAudit(Store $store, App\Models\User $user, int $completedDaysAgo, array $severities): OshaViolationAudit
{
    $completedAt = CarbonImmutable::now()->subDays($completedDaysAgo);

    /** @var OshaViolationAudit $audit */
    $audit = OshaViolationAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $user->id,
        'store_id' => $store->id,
        'date' => $completedAt,
        'grade' => 'A',
        'completed_date' => $completedAt,
    ]);

    foreach ($severities as $severity) {
        $audit->violations()->create([
            'uuid' => (string) Str::uuid(),
            'statement_id' => 1,
            'statement' => 'Test',
            'severity' => $severity,
        ]);
    }

    return $audit->refresh()->load('violations');
}
