<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Document\Actions;

use App\Domain\Tenant\Document\Data\CreateDealerDocData;
use App\Models\Dealer\Store;
use App\Models\DealerDoc;
use Illuminate\Http\UploadedFile;
use RuntimeException;

class CreateDealerDoc
{
    public function handle(CreateDealerDocData $data): DealerDoc
    {
        $store = Store::query()->firstOrFail();

        [$filePath, $fileName] = $this->storeFile($data);

        return DealerDoc::query()->create([
            'store_id' => $store->id,
            'title' => $data->title,
            'url' => $data->url ?: null,
            'file_name' => $fileName,
            'file_path' => $filePath,
        ]);
    }

    /**
     * @return array{0: string, 1: string}
     */
    private function storeFile(CreateDealerDocData $data): array
    {
        if (! $data->file instanceof UploadedFile) {
            return ['', ''];
        }

        $stored = $data->file->store(tenant()->id, 'dealer-docs');

        throw_unless($stored, RuntimeException::class, 'Unable to store the uploaded file.');

        return [(string) $stored, $data->file->getClientOriginalName()];
    }
}
