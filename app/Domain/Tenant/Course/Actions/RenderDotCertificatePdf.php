<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Course\Actions;

use App\Domain\Tenant\Course\DotCertificate;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Browsershot\Browsershot;

/**
 * Render the DOT certificate PDF and persist both the artifact and the
 * Certificate row. Used by the async IssueDotCertificate job (self-serve flow)
 * and the sync GenerateDotCertificate action (admin flow) so the two paths
 * cannot diverge on filename, storage path, or DB shape.
 */
class RenderDotCertificatePdf
{
    public function handle(User $user, string $storeName, string $passedOn): string
    {
        $html = view('dealer.course.CertDownloadView', [
            'user' => $user,
            'store' => $storeName,
            'passed_on' => $passedOn,
        ])->render();

        $fileName = Str::slug($user->name).'-'.now()->format('m-d-Y').'-dot-certificate.pdf';
        $filePath = tenant('id').'/'.$user->id.'/'.$fileName;

        Storage::disk(DotCertificate::STORAGE_DISK)->put(
            $filePath,
            Browsershot::html($html)->landscape()->pdf(),
        );

        $user->certificates()->create([
            'course_name' => DotCertificate::COURSE_NAME,
            'file_name' => $fileName,
        ]);

        return $filePath;
    }
}
