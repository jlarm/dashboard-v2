<?php

declare(strict_types=1);

namespace App\Http\Controllers\Central;

use App\Domain\Central\SharedDocuments\Actions\CreateSharedDocument;
use App\Domain\Central\SharedDocuments\Actions\DeleteSharedDocument;
use App\Domain\Central\SharedDocuments\Data\SharedDocumentData;
use App\Domain\Central\SharedDocuments\Queries\SearchSharedDocuments;
use App\Domain\Central\SharedDocuments\Support\SharedDocumentStorage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Central\SharedDocument\StoreSharedDocumentRequest;
use App\Http\Resources\Central\SharedDocumentResource;
use App\Models\SharedDocument;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SharedDocumentController extends Controller
{
    public function index(
        Request $request,
        SearchSharedDocuments $searchSharedDocuments,
    ): Response {
        $this->authorize('viewAny', SharedDocument::class);

        /** @var User $user */
        $user = $request->user();

        $search = $request->string('search')->toString() ?: null;

        return Inertia::render('central/shared-document/Index', [
            'documents' => SharedDocumentResource::collection(
                $searchSharedDocuments->handle($search)
            ),
            'filters' => $request->only(['search']),
            'can' => [
                'create' => $user->can('create', SharedDocument::class),
                'delete' => $user->can('delete', SharedDocument::class),
            ],
        ]);
    }

    public function store(
        StoreSharedDocumentRequest $request,
        CreateSharedDocument $action,
    ): RedirectResponse {
        $this->authorize('create', SharedDocument::class);

        $file = $request->file('file');

        $action->handle(new SharedDocumentData(
            title: $request->validated('title'),
            url: $request->validated('url') ?: null,
            file: $file instanceof UploadedFile ? $file : null,
        ));

        return back()->with('flash.success', 'Document uploaded successfully.');
    }

    public function download(
        SharedDocument $sharedDocument,
        SharedDocumentStorage $storage,
    ): StreamedResponse {
        $this->authorize('view', $sharedDocument);

        abort_unless(is_string($sharedDocument->file_name) && $sharedDocument->file_name !== '', 404);

        return $storage->response($sharedDocument->file_name);
    }

    public function destroy(
        SharedDocument $sharedDocument,
        DeleteSharedDocument $action,
    ): RedirectResponse {
        $this->authorize('delete', $sharedDocument);

        $action->handle($sharedDocument);

        return back()->with('flash.success', 'Document deleted successfully.');
    }
}
