<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant;

use App\Domain\Tenant\Document\Actions\CreateDealerDoc;
use App\Domain\Tenant\Document\Actions\DeleteDealerDoc;
use App\Domain\Tenant\Document\Queries\GetDealerDocs;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\Document\IndexDealerDocsRequest;
use App\Http\Requests\Tenant\Document\StoreDealerDocRequest;
use App\Http\Resources\Tenant\DealerDocListItemResource;
use App\Models\DealerDoc;
use App\Models\SharedDocument;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

class DealerDocController extends Controller
{
    public function index(IndexDealerDocsRequest $request, GetDealerDocs $getDealerDocs): InertiaResponse
    {
        /** @var User $user */
        $user = $request->user();

        $search = $request->search();
        $paginator = $getDealerDocs->handle($search, $request->page());

        return Inertia::render('tenant/document/Index', [
            'docs' => DealerDocListItemResource::collection($paginator),
            'filters' => [
                'search' => $search === '' ? null : $search,
            ],
            'can' => [
                'create' => $user->can('create', DealerDoc::class),
            ],
        ]);
    }

    public function store(StoreDealerDocRequest $request, CreateDealerDoc $createDealerDoc): RedirectResponse
    {
        try {
            $createDealerDoc->handle($request->toData());
        } catch (Throwable $e) {
            report($e);

            return back()
                ->withInput()
                ->with('flash.error', 'We could not save the document. Please try again.');
        }

        return back()->with('flash.success', 'Document added successfully.');
    }

    public function destroy(DealerDoc $dealerDoc, DeleteDealerDoc $deleteDealerDoc): RedirectResponse
    {
        $this->authorize('delete', $dealerDoc);

        try {
            $deleteDealerDoc->handle($dealerDoc);
        } catch (Throwable $e) {
            report($e);

            return back()->with('flash.error', 'We could not delete the document. Please try again.');
        }

        return back()->with('flash.success', 'Document deleted successfully.');
    }

    public function download(DealerDoc $dealerDoc): StreamedResponse
    {
        $disk = Storage::disk('dealer-docs');
        $filePath = $dealerDoc->file_path;

        abort_unless(is_string($filePath) && $filePath !== '' && $disk->exists($filePath), 404);

        return $disk->response(
            $filePath,
            $dealerDoc->file_name !== '' ? $dealerDoc->file_name : null,
        );
    }

    public function downloadShared(int $sharedDocument): StreamedResponse
    {
        return tenancy()->central(function () use ($sharedDocument): StreamedResponse {
            $doc = SharedDocument::query()->findOrFail($sharedDocument);
            $disk = Storage::disk('central-docs');

            abort_unless(is_string($doc->file_name) && $doc->file_name !== '' && $disk->exists($doc->file_name), 404);

            return $disk->response($doc->file_name);
        });
    }
}
