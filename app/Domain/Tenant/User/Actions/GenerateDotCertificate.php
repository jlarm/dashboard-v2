<?php

declare(strict_types=1);

namespace App\Domain\Tenant\User\Actions;

use App\Domain\Tenant\User\Queries\GetEmployeeCertificates;
use App\Models\Certificate;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;
use Spatie\Browsershot\Browsershot;

class GenerateDotCertificate
{
    private const string COURSE_NAME = 'DOT Hazardous Materials Transportation';

    public function __construct(private readonly GetEmployeeCertificates $certificates) {}

    public function handle(User $user, string $storeName): string
    {
        throw_unless($this->certificates->canGenerateDotCertificate($user), RuntimeException::class, 'Employee is not eligible for a DOT certificate.');

        $passedOn = $this->certificates->dotCourseResult($user)
            ?->created_at
            ?->format('F d, Y') ?? now()->format('F d, Y');

        $html = view('dealer.course.CertDownloadView', [
            'user' => $user,
            'store' => $storeName,
            'passed_on' => $passedOn,
        ])->render();

        $fileName = Str::slug($user->name).'-'.now()->format('m-d-Y').'-dot-certificate.pdf';
        $filePath = tenant('id').'/'.$user->id.'/'.$fileName;

        Storage::disk('armp-certs')->put($filePath, Browsershot::html($html)->landscape()->pdf());

        Certificate::query()->create([
            'user_id' => $user->id,
            'course_name' => self::COURSE_NAME,
            'file_name' => $fileName,
        ]);

        return Storage::disk('armp-certs')->temporaryUrl($filePath, now()->addHour());
    }
}
