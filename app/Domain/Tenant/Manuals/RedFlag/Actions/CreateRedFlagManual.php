<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Manuals\RedFlag\Actions;

use App\Domain\Tenant\Manuals\RedFlag\Data\RedFlagManualFormData;
use App\Jobs\Manuals\GenerateRedFlagManualJob;
use App\Jobs\Manuals\UploadRedFlagToDigitalOceanJob;
use App\Models\Dealer\Manual\RedFlag;
use App\Models\Dealer\Settings\EmployeeList;
use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CreateRedFlagManual
{
    public function handle(Store $store, User $user, RedFlagManualFormData $formData): RedFlag
    {
        return DB::transaction(function () use ($store, $user, $formData): RedFlag {
            $employeeList = EmployeeList::query()
                ->where('store_id', $store->id)
                ->first();

            $signatureFileName = $this->buildSignatureFileName($user);

            Storage::put(
                'red-flag-signatures/'.$signatureFileName,
                $this->decodeSignature($formData->signatureDataUri),
            );

            /** @var RedFlag $manual */
            $manual = RedFlag::query()->create([
                'store_id' => $store->id,
                'user_id' => $user->id,
                'qualified_individual_name' => $this->fromEmployeeList($employeeList, 'qualified_individual_name'),
                'qualified_individual_phone' => $this->fromEmployeeList($employeeList, 'qualified_individual_phone'),
                'service_manager_name' => $this->fromEmployeeList($employeeList, 'service_manager_name'),
                'service_manager_phone' => $this->fromEmployeeList($employeeList, 'service_manager_phone'),
                'parts_manager_name' => $this->fromEmployeeList($employeeList, 'parts_manager_name'),
                'parts_manager_phone' => $this->fromEmployeeList($employeeList, 'parts_manager_phone'),
                'body_shop_manager_name' => $this->fromEmployeeList($employeeList, 'body_shop_manager_name'),
                'body_shop_manager_phone' => $this->fromEmployeeList($employeeList, 'body_shop_manager_phone'),
                'general_manager_name' => $this->fromEmployeeList($employeeList, 'general_manager_name'),
                'general_manager_phone' => $this->fromEmployeeList($employeeList, 'general_manager_phone'),
                'owner_name' => $this->fromEmployeeList($employeeList, 'owner_name'),
                'owner_phone' => $this->fromEmployeeList($employeeList, 'owner_phone'),
                'police_emergency_phone' => (string) ($store->police_emergency_phone ?? ''),
                'police_non_emergency_phone' => (string) ($store->police_non_emergency_phone ?? ''),
                'fire_emergency_phone' => (string) ($store->fire_emergency_phone ?? ''),
                'fire_non_emergency_phone' => (string) ($store->fire_non_emergency_phone ?? ''),
                'fire_alarm_type' => (string) ($store->fire_alarm_type ?? ''),
                'burglar_alarm_type' => (string) ($store->burglar_alarm_type ?? ''),
                'signature' => $signatureFileName,
            ]);

            Bus::chain([
                new GenerateRedFlagManualJob($manual),
                new UploadRedFlagToDigitalOceanJob($manual),
            ])->dispatch();

            return $manual;
        });
    }

    private function buildSignatureFileName(User $user): string
    {
        $slug = Str::of((string) $user->name)->replace(' ', '')->lower();

        return $slug.now()->format('YmdHis').'.png';
    }

    private function decodeSignature(string $dataUri): string
    {
        $base64 = Str::of($dataUri)->after(',');

        return (string) base64_decode((string) $base64, true);
    }

    private function fromEmployeeList(?Model $employeeList, string $field): string
    {
        if (! $employeeList instanceof EmployeeList) {
            return '';
        }

        return (string) ($employeeList->{$field} ?? '');
    }
}
