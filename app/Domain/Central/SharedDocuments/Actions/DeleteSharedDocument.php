<?php

declare(strict_types=1);

namespace App\Domain\Central\SharedDocuments\Actions;

use App\Domain\Central\SharedDocuments\Support\SharedDocumentStorage;
use App\Models\SharedDocument;
use Illuminate\Support\Facades\DB;

class DeleteSharedDocument
{
    public function __construct(
        private readonly SharedDocumentStorage $storage,
    ) {}

    public function handle(SharedDocument $sharedDocument): void
    {
        DB::transaction(function () use ($sharedDocument): void {
            $fileName = $sharedDocument->file_name;

            $sharedDocument->delete();

            $this->storage->delete($fileName);
        });
    }
}
