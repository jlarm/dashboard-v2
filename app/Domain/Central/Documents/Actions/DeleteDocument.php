<?php

declare(strict_types=1);

namespace App\Domain\Central\Documents\Actions;

use App\Domain\Central\Documents\Support\DocumentStorage;
use App\Models\Document;
use Illuminate\Support\Facades\DB;

class DeleteDocument
{
    public function __construct(
        private readonly DocumentStorage $storage,
    ) {}

    public function handle(Document $document): void
    {
        DB::transaction(function () use ($document): void {
            $fileName = $document->file_name;

            $document->delete();

            $this->storage->delete($fileName);
        });
    }
}
