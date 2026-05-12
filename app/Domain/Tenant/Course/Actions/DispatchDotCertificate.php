<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Course\Actions;

use App\Domain\Tenant\Course\Queries\CanIssueDotCertificate;
use App\Jobs\IssueDotCertificate;
use App\Models\User;

class DispatchDotCertificate
{
    public const string COURSE_NAME = 'DOT Hazardous Materials Transportation';

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
