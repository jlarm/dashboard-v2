<?php

declare(strict_types=1);

namespace App\Domain\Tenant\User\Queries;

use App\Domain\Tenant\Course\DotCertificate;
use App\Domain\Tenant\Course\Queries\CanIssueDotCertificate;
use App\Models\Certificate;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class GetEmployeeCertificates
{
    public function __construct(private readonly CanIssueDotCertificate $eligibility) {}

    /**
     * @return list<array{
     *     id: int,
     *     course_name: string,
     *     issued_on: string,
     *     download_url: string
     * }>
     */
    public function certificates(User $user): array
    {
        $tenantId = (string) (tenant('id') ?? '');

        return array_values(
            $user->certificates()
                ->select(['id', 'user_id', 'course_name', 'file_name', 'created_at'])
                ->latest()
                ->get()
                ->map(fn (Certificate $cert): array => [
                    'id' => (int) $cert->id,
                    'course_name' => (string) $cert->course_name,
                    'issued_on' => $cert->created_at?->format('F d, Y') ?? '',
                    'download_url' => Storage::disk(DotCertificate::STORAGE_DISK)->temporaryUrl(
                        "{$tenantId}/{$user->id}/{$cert->file_name}",
                        now()->addMinutes(2),
                    ),
                ])
                ->all(),
        );
    }

    public function canGenerateDotCertificate(User $user): bool
    {
        return $this->eligibility->handle($user);
    }
}
