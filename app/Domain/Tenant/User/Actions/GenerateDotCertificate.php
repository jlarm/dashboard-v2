<?php

declare(strict_types=1);

namespace App\Domain\Tenant\User\Actions;

use App\Domain\Tenant\Course\Actions\RenderDotCertificatePdf;
use App\Domain\Tenant\Course\DotCertificate;
use App\Domain\Tenant\Course\Queries\CanIssueDotCertificate;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class GenerateDotCertificate
{
    public function __construct(
        private readonly CanIssueDotCertificate $eligibility,
        private readonly RenderDotCertificatePdf $render,
    ) {}

    public function handle(User $user): string
    {
        throw_unless(
            $this->eligibility->handle($user),
            RuntimeException::class,
            'Employee is not eligible for a DOT certificate.',
        );

        $passedOn = $this->eligibility->latestPassedResult($user)
            ?->created_at
            ?->format('F d, Y') ?? now()->format('F d, Y');

        $filePath = $this->render->handle($user, $this->resolveStoreName(), $passedOn);

        return Storage::disk(DotCertificate::STORAGE_DISK)->temporaryUrl($filePath, now()->addHour());
    }

    private function resolveStoreName(): string
    {
        if (app()->bound('currentStoreModel')) {
            return (string) resolve('currentStoreModel')->name;
        }

        return (string) tenant('name');
    }
}
