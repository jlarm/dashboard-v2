<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Audits\Actions;

use App\Models\Dealer\Audit\Contracts\ViolationAudit;
use App\Models\Dealer\Violation;
use App\Models\ViolationStatement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AddViolationFromStatement
{
    public function handle(ViolationAudit&Model $audit, int $statementId): Violation
    {
        $statement = tenancy()->central(fn () => ViolationStatement::query()->findOrFail($statementId));

        /** @var Violation $violation */
        $violation = $audit->violations()->create([
            'uuid' => (string) Str::uuid(),
            'statement_id' => $statement->id,
            'statement' => $statement->statement,
            'risk' => false,
        ]);

        return $violation;
    }
}
