<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Domain\Tenant\Course\Actions\DispatchDotCertificate;
use App\Models\Certificate;
use App\Models\User;
use App\Notifications\DotCertificateReadyNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Browsershot\Browsershot;
use Throwable;

class IssueDotCertificate implements ShouldQueue
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

    public function handle(): void
    {
        $user = User::query()->find($this->userId);
        if (! $user instanceof User) {
            return;
        }

        if (Certificate::query()
            ->where('user_id', $user->id)
            ->where('course_name', DispatchDotCertificate::COURSE_NAME)
            ->exists()
        ) {
            return;
        }

        $html = view('dealer.course.CertDownloadView', [
            'user' => $user,
            'store' => $this->storeName,
            'passed_on' => $this->passedOn,
        ])->render();

        $pdf = Browsershot::html($html)->landscape()->pdf();

        $fileName = Str::slug($user->name).'-'.now()->format('m-d-Y').'-dot-certificate.pdf';

        Storage::disk('armp-certs')->put(tenant('id').'/'.$user->id.'/'.$fileName, $pdf);

        Certificate::query()->create([
            'user_id' => $user->id,
            'course_name' => DispatchDotCertificate::COURSE_NAME,
            'file_name' => $fileName,
        ]);

        $user->notify(new DotCertificateReadyNotification);
    }

    public function failed(?Throwable $exception): void
    {
        report_if($exception instanceof Throwable, $exception);
    }
}
