<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Domain\Tenant\Course\Actions\RenderDotCertificatePdf;
use App\Domain\Tenant\Course\DotCertificate;
use App\Models\User;
use App\Notifications\DotCertificateReadyNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUniqueUntilProcessing;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class IssueDotCertificate implements ShouldBeUniqueUntilProcessing, ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $timeout = 180;

    public function __construct(
        public readonly int $userId,
        public readonly string $storeName,
        public readonly string $passedOn,
    ) {}

    /**
     * @return array<int, int>
     */
    public function backoff(): array
    {
        return [10, 60, 300];
    }

    public function uniqueId(): string
    {
        return (string) $this->userId;
    }

    public function handle(RenderDotCertificatePdf $render): void
    {
        $user = User::query()->find($this->userId);
        if (! $user instanceof User) {
            return;
        }

        if ($user->certificates()
            ->where('course_name', DotCertificate::COURSE_NAME)
            ->exists()
        ) {
            return;
        }

        $render->handle($user, $this->storeName, $this->passedOn);

        $user->notify(new DotCertificateReadyNotification);
    }

    public function failed(?Throwable $exception): void
    {
        report_if($exception instanceof Throwable, $exception);
    }
}
