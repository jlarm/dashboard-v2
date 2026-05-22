<?php

declare(strict_types=1);

namespace App\Http\Controllers\Central;

use App\Domain\Central\Documents\Actions\CreateDocument;
use App\Domain\Central\Documents\Actions\DeleteDocument;
use App\Domain\Central\Documents\Data\DocumentData;
use App\Domain\Central\Documents\Queries\SearchDocuments;
use App\Domain\Central\Documents\Support\DocumentStorage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Central\Document\StoreDocumentRequest;
use App\Http\Resources\Central\DocumentResource;
use App\Models\Document;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DocumentController extends Controller
{
    public function index(
        Request $request,
        SearchDocuments $searchDocuments,
    ): Response {
        $this->authorize('viewAny', Document::class);

        /** @var User $user */
        $user = $request->user();

        $search = $request->string('search')->toString() ?: null;

        return Inertia::render('central/document/Index', [
            'documents' => DocumentResource::collection(
                $searchDocuments->handle($search)
            ),
            'filters' => $request->only(['search']),
            'can' => [
                'create' => $user->can('create', Document::class),
                'delete' => $user->can('delete', Document::class),
            ],
        ]);
    }

    public function store(
        StoreDocumentRequest $request,
        CreateDocument $action,
    ): RedirectResponse {
        $this->authorize('create', Document::class);

        $file = $request->file('file');

        $action->handle(new DocumentData(
            title: $request->validated('title'),
            url: $request->validated('url') ?: null,
            file: $file instanceof UploadedFile ? $file : null,
        ));

        return back()->with('flash.success', 'Document uploaded successfully.');
    }

    public function download(
        Document $document,
        DocumentStorage $storage,
    ): StreamedResponse {
        $this->authorize('view', $document);

        abort_unless(is_string($document->file_name) && $document->file_name !== '', 404);

        return $storage->response($document->file_name);
    }

    public function destroy(
        Document $document,
        DeleteDocument $action,
    ): RedirectResponse {
        $this->authorize('delete', $document);

        $action->handle($document);

        return back()->with('flash.success', 'Document deleted successfully.');
    }
}
