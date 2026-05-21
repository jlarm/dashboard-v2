<?php

declare(strict_types=1);

namespace App\Domain\Tenant\FitTests\Actions;

use App\Domain\Tenant\FitTests\Data\CreateFitTestData;
use App\Models\Dealer\Store;
use App\Models\FitTestDoc;
use RuntimeException;

class CreateFitTest
{
    public function handle(Store $store, CreateFitTestData $data): FitTestDoc
    {
        $filePath = $data->file->store(tenant()->id.'/fits', 'dealer-docs');

        throw_unless(
            is_string($filePath) && $filePath !== '',
            RuntimeException::class,
            'Unable to store the uploaded fit test file.',
        );

        return FitTestDoc::query()->create([
            'store_id' => $store->id,
            'user_id' => $data->userId,
            'employee_name' => $data->employeeName,
            'date' => $data->date,
            'file_path' => $filePath,
        ]);
    }
}
