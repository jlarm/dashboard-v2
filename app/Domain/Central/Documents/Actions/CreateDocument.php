<?php

declare(strict_types=1);

namespace App\Domain\Central\Documents\Actions;

use App\Domain\Central\Documents\Data\DocumentData;
use App\Domain\Central\Documents\Support\DocumentStorage;
use App\Models\Document;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class CreateDocument
{
    public function __construct(
        private readonly DocumentStorage $storage,
    ) {}

    public function handle(DocumentData $data): Document
    {
        return DB::transaction(function () use ($data): Document {
            $fileName = $data->file instanceof UploadedFile ? $this->storage->store($data->file) : null;

            return Document::query()->create([
                'title' => $data->title,
                'url' => $data->url,
                'file_name' => $fileName,
            ]);
        });
    }
}
