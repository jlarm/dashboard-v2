<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Course\Actions;

use App\Domain\Tenant\Course\DotCertificate;
use App\Domain\Tenant\Course\Queries\CanIssueDotCertificate;
use App\Jobs\IssueDotCertificate;
use App\Models\User;

class DispatchDotCertificate
{
    /**
     * @deprecated Use App\Domain\Tenant\Course\DotCertificate::COURSE_NAME.
     *             Retained for backwards compatibility while callers migrate.
     */
    public const string COURSE_NAME = DotCertificate::COURSE_NAME;

    public function __construct(private readonly CanIssueDotCertificate $canIssue) {}

    public function handle(User $user, string $storeName, string $passedOn): bool
    {
        if (! $this->canIssue->handle($user)) {
            return false;
        }

        IssueDotCertificate::dispatch($user->id, $storeName, $passedOn);

        return true;
    }
}
