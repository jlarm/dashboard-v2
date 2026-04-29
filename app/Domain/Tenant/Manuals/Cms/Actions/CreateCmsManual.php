<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Manuals\Cms\Actions;

use App\Domain\Tenant\Manuals\Cms\Data\CmsManualFormData;
use App\Jobs\Manuals\GenerateCmsManualJob;
use App\Jobs\Manuals\UploadCmsToDigitalOceanJob;
use App\Models\CmsManual;
use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CreateCmsManual
{
    public function handle(Store $store, User $user, CmsManualFormData $formData): CmsManual
    {
        return DB::transaction(function () use ($store, $user, $formData): CmsManual {
            $aanOne = $this->buildSignatureFileName('adoption_one', $formData->adoptionApprovalNameOne);
            $aanTwo = $this->buildSignatureFileName('adoption_two', $formData->adoptionApprovalNameTwo);
            $aanThree = $this->buildSignatureFileName('adoption_three', $formData->adoptionApprovalNameThree);
            $dpn = $this->buildSignatureFileName('dealer_participation', $formData->dealerParticipationName);
            $an = $this->buildSignatureFileName('acknowledgement', $formData->acknowledgementName);

            /** @var CmsManual $manual */
            $manual = CmsManual::query()->create([
                'user_id' => $user->id,
                'store_id' => $store->id,
                'qi_name' => $formData->qiName,
                'standard_dpp_rate' => $formData->standardDppRate,
                'adoption_approval_name_one' => $formData->adoptionApprovalNameOne,
                'adoption_approval_signature_one' => $aanOne ?? '',
                'adoption_approval_name_two' => $formData->adoptionApprovalNameTwo,
                'adoption_approval_signature_two' => $aanTwo ?? '',
                'adoption_approval_name_three' => $formData->adoptionApprovalNameThree,
                'adoption_approval_signature_three' => $aanThree ?? '',
                'dealer_participation_program_name' => $formData->dealerParticipationName,
                'dealer_participation_program_signature' => $dpn ?? '',
                'acknowledgement_name' => $formData->acknowledgementName,
                'acknowledgement_signature' => $an ?? '',
            ]);

            $this->saveSignature($aanOne, $formData->adoptionApprovalSignatureOne);
            $this->saveSignature($aanTwo, $formData->adoptionApprovalSignatureTwo);
            $this->saveSignature($aanThree, $formData->adoptionApprovalSignatureThree);
            $this->saveSignature($dpn, $formData->dealerParticipationSignature);
            $this->saveSignature($an, $formData->acknowledgementSignature);

            Bus::chain([
                new GenerateCmsManualJob($manual),
                new UploadCmsToDigitalOceanJob($manual),
            ])->dispatch();

            return $manual;
        });
    }

    private function buildSignatureFileName(string $slot, ?string $name): ?string
    {
        if ($name === null || $name === '') {
            return null;
        }

        $slug = Str::of($name)->replace(' ', '_')->lower();

        return $slot.'_'.$slug.'_'.now()->format('YmdHis').'.png';
    }

    private function saveSignature(?string $fileName, ?string $dataUri): void
    {
        if ($fileName === null || $dataUri === null || $dataUri === '') {
            return;
        }

        $base64 = Str::of($dataUri)->after(',');

        Storage::put('cms-signatures/'.$fileName, (string) base64_decode((string) $base64, true));
    }
}
