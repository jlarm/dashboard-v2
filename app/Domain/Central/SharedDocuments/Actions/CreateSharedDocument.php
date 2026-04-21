<?php

declare(strict_types=1);

namespace App\Domain\Central\SharedDocuments\Actions;

use App\Domain\Central\SharedDocuments\Data\SharedDocumentData;
use App\Domain\Central\SharedDocuments\Support\SharedDocumentStorage;
use App\Models\SharedDocument;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class CreateSharedDocument
{
    public function __construct(
        private readonly SharedDocumentStorage $storage,
    ) {}

    public function handle(SharedDocumentData $data): SharedDocument
    {
        return DB::transaction(function () use ($data): SharedDocument {
            $fileName = $data->file instanceof UploadedFile ? $this->storage->store($data->file) : null;

            return SharedDocument::query()->create([
                'title' => $data->title,
                'url' => $data->url,
                'file_name' => $fileName,
            ]);
        });
    }
}
