<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Audits\Actions;

use App\Enums\ViolationAuditType;
use App\Models\Dealer\Audit\Contracts\ViolationAudit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Bus;

class DispatchAuditPdfGeneration
{
    public function handle(ViolationAuditType $type, ViolationAudit&Model $audit): void
    {
        $generateClass = $type->generatePdfJobClass();
        $uploadClass = $type->uploadPdfJobClass();

        Bus::chain([
            new $generateClass($audit),
            new $uploadClass($audit),
        ])->dispatch();
    }
}
